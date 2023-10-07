<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use Google_Service_Sheets;
use app\models\Budget;
use app\models\Category;
use app\models\Product;

class GoogleAPIController extends Controller
{
    /**
     * @var Google_Service_Sheets
     */
    private $service;

    public function actionIndex()
    {
        $sheetUrl = Yii::$app->params['googleSheetsUrl'];
        $urlParts = explode('/', $sheetUrl);
        $spreadsheetId = $urlParts[5];

        $credentialPath = realpath(__DIR__ . '/../config/masterbudget.json');
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialPath);
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS);

        $this->service = new \Google_Service_Sheets($client);

        $response = $this->service->spreadsheets_values->get($spreadsheetId, "'MA'!A:M");

        $values = $response->getValues(); // Получите массив значений

        if (!empty($values)) {
            $values = array_slice($values, 3); // Уберите первую строку с месяцами

            foreach ($values as $row) {
                // Проверяем, является ли строка пустой
                if (!empty(array_filter($row))) {
                    // Если строка содержит только один элемент, это категория
                    if (count($row) === 1) {
                        $currentCategory = $row[0];
                    } else {
                        // Если строка содержит более одного элемента, это продукт и данные по месяцам
                        $productName = $row[0]; // Первый элемент строки - это продукт

                        // Проверяем, не пустое ли имя продукта
                        if (!empty($productName) && trim($productName) != 'Total') {
                            $category = Category::findOne(['name' => $currentCategory]);
                            if (!$category) {
                                // Если категория не найдена, создаем новую
                                $category = new Category();
                                $category->name = $currentCategory;
                                $category->save();
                            }

                            // Создаем новую запись бюджета и связываем ее с категорией
                            $product = Product::findOne(['name' => $productName]);
                            if (!$product) {
                                $product = new Product();
                                $product->name = $productName;
                                $product->category_id = $category->id;
                                $product->save();
                            }

                            $budgetValues = array_slice($row, 1);

                            // Получаем список названий месяцев
                            $monthColumns = [
                                'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
                            ];

                            foreach ($monthColumns as $i => $monthColumn) {
                                // Получаем значение бюджета для текущего месяца
                                $budgetAmount = isset($budgetValues[$i]) ? $budgetValues[$i] : null;

                                $budget = Budget::findOne(['product_id' => $product->id]);
                                if (!$budget) {
                                    $budget = new Budget();
                                    $budget->product_id = $product->id;
                                }

                                $budgetAmount = $budgetAmount === '' ? 0 : $budgetAmount; // Если пустая строка, заменяем на 0
                                $budget->$monthColumn = floatval(str_replace(['$', ','], '', $budgetAmount)); // Убираем $ и , далее преобразовываем строку в числовой формат
                                $budget->save();
                            }
                        }
                    }
                }

                if (in_array('CO-OP', $row)) {
                    break;
                }
            }

            echo "Данные успешно добавлены в базу данных.\n";
        } else {
            echo "Нет данных в таблице 'MA'.\n";
        }
    }
}
