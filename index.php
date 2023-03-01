<!DOCTYPE html>
<html>

<head>
    <title>Склад товаров</title>
    <style>
        input {
            width: 200px;
            margin-bottom: 10px;
        }

        #info {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #000;
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h1>Склад товаров</h1>
    <form action="" method="post">
        <label for="date">Выберите дату:</label><br />
        <input type="date" name="date" id="date" /><br />
        <input type="submit" value="Применить" name="submit" />
    </form>
    <?php
    require_once 'Product.php';
    
    if (isset($_POST['submit'])) {
        $date = $_POST['date'];
        if (empty($date)) {
            echo '<div id="info">Вы не ввели дату.</div>';
        } else {
            $conn = new SQLite3('database.db');

            // Создаем таблицу
            $sql = "CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY,
            date DATE NOT NULL,
            remaining_stock INTEGER NOT NULL,
            current_price INTEGER NOT NULL
            )";
            $conn->exec($sql);
            
            
            // Добавляем записи
            $sql = "INSERT INTO products (date, remaining_stock, current_price)
            VALUES ('2021-01-13', 8, 1000),
                ('2021-01-14', 13, 1400),
                ('2021-01-15', 21, 2000),
                ('2021-01-16', 34, 2800),
                ('2021-01-17', 55, 4000),
                ('2021-01-18', 89, 6400),
                ('2021-01-19', 144, 10200),
                ('2021-01-20', 233, 16400),
                ('2021-01-21', 377, 26300)";
            $conn->exec($sql); 
            
            // Выполняем запрос
            $sql = "SELECT remaining_stock, current_price FROM products WHERE date = '$date'";
            $result = $conn->query($sql);

            // Определяем переменную для хранения товара
            $product = null;

            // Проверяем нашли ли мы данные
            $rows = 0;
            while ($row = $result->fetchArray()) {
            $rows++;

            
            
            
            
            // Инициализируем переменную хранения товара
            $product = new Product( $row['remaining_stock'], $row['current_price']);
                
                echo '<div id="info">';
                //Выводим дату для определения
                echo 'Дата ' . $date . '<br />';
                echo 'Остаток на складе: ' . $row['remaining_stock'] . '<br />';

            // Переменная для хранения стоимости товара
            $price = 0;

            // Получаем себестоимость товара
            $cost = $product->getCost();

            // Устанавливаем цену товара с 30% наценкой
            $price = $cost + ($cost * 0.3);

            // Выводим цену товара
                echo 'Цена товара: ' . $price . '<br />';
                echo '</div>';
            }

                   
            if ($rows == 0) {
                echo '<div id="info">Не верная дата.</div>';
            }
        }
    }

    
    ?>
</body>

</html>