<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">

<html>
<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251" />
    <TITLE>Дискретна матиматика</TITLE>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div>
    <div>
        <h3>Деякі операції над графом</h3>
        <h4>Виконала Гіль Аліса</h4>
    </div>
</div>
<form action="result.php" enctype="multipart/form-data" method="POST">
    <label>
        <input type="checkbox" name="incMatrix"> Побудувати матрицю інцидентності
    </label>
    <br>
    <label>
        <input type="checkbox" name="contMatrix"> Побудувати матрицю суміжності
    </label>
    <br>
    <label>
        <input type="checkbox" name="power"> Визначити степінь вершин графу
    </label>
    <br>
    <label>
        <input type="checkbox" name="hang-isol"> Висячі та ізольовані вершини
    </label>
    <br>
    <label>
        <input type="checkbox" name="dist-reach"> Матриці відстані та досяжності
    </label>
    <br>
    <label>
        <input type="checkbox" name="cycles"> Наявність циклів
    </label>
    <br>
    <label>
        <input type="checkbox" name="cohesion"> Визначити тип зв'язності
    </label>
    <br>
    <label>
        <input type="checkbox" name="dfs_method"> Обхід графу вглиб
    </label>
    <br>
    <label>
        <input type="checkbox" name="bfs_method"> Обхід графу вшир
    </label>
    <br>
    <br>
    <input type="submit" value="Отправить">
</form>
<br>

</body>
</html>

<!--array(9, 2),
array(1, 1),
array(3, 4),
array(5, 9),
array(8, 5),
array(7, 6),
array(9, 10),-!>
