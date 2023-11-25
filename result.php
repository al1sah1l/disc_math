<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">
<?php include 'functions.php';?>
<html>
<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251" />
    <TITLE>Дискретна математика</TITLE>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h3>Деякі операції над графом</h3>
    <h4>Виконала Гіль Аліса</h4>
<br>
<?php

$file = file_get_contents("data3.txt");
$vertexCount = $file[0];
$ribsCount = $file[2];

$temp = 2;
for ($i = 0; $i < strlen($file) / 2; $i++) {
    $listOfRibs[$i] = [$file[$temp + 3], $file[$temp + 5]];
    $temp += 5;
}

echo "Кількість вершин: " . $vertexCount;
echo "<br>";
echo "Кількість ребер: " . $ribsCount;
echo "<br>";
echo "<br>";?>

<div class="block-style">
<h4 class="text-style">Список ребер:</h4>
<?php

for ($i = 0; $i < $ribsCount; $i++){
    for ($j = 0; $j < 2; $j++){
        echo $listOfRibs[$i][$j] . " ";
    }
    $incMatrix = getIncidenceMatrix($listOfRibs, $vertexCount, $ribsCount);
    $contMatrix = getContiguityMatrix($listOfRibs, $vertexCount, $ribsCount);
    $size = sizeof($contMatrix);
    echo "<br>";
}?>

<?php if (!empty($_POST['incMatrix'])){?>
    <h4 class="text-style">Матриця інцидентності:</h4>
    <?php printMatrix($incMatrix);
}?>

<?php if (!empty($_POST['contMatrix'])){?>
    <h4 class="text-style">Матриця суміжності:</h4>
    <?php printMatrix($contMatrix);
}?>
</div>

<div class="block-style">
    <div>
        <div class="block-style">
            <?php if (!empty($_POST['power'])){?>
                <h4 class="text-style">Степені вершин графу:</h4>
                <?php writeList(getGeneralPowerOfVertexes($incMatrix), 1);
            }?>
        </div>

        <div class="block-style">
            <?php if (!empty($_POST['power'])){?>
                <h4 class="text-style">Півстепені виходу вершин:</h4>
                <?php writeList(getOutPower($contMatrix), 2);
            }?>
        </div>

        <div class="block-style">
            <?php if (!empty($_POST['power'])){?>
                <h4 class="text-style">Півстепені входу вершин:</h4>
                <?php writeList(getInPower($contMatrix), 3);
            }?>
        </div>
    </div>
    <br>
    <?php if (!empty($_POST['power'])){
        if (isSmooth(getGeneralPowerOfVertexes($incMatrix)) == true){?>
        <p>Граф однорідний</p>
        <p>Степінь однорідності: <?php echo getGeneralPowerOfVertexes($incMatrix)[0][1]?></p>
        <?php } else{?>
        <p>Граф НЕоднорідний</p>
        <?php }
    }?>
</div>
<div class="block-style">
    <?php if (!empty($_POST['hang-isol'])){?>
        <h4 class="text-style">Ізольовані вершини:</h4>
        <?php $list = findIsolatedVertexes(getGeneralPowerOfVertexes($incMatrix));
        if (sizeof($list) != 0) {
            for ($i = 0; $i < sizeof($list); $i++) {
                echo "v" . $list[$i] . "; ";
            }
        } else{
            echo "Немає ізольованих вершин";
        }?>
        <h4 class="text-style">Висячі вершини:</h4>
        <?php $list = findHangingVertexes(getGeneralPowerOfVertexes($incMatrix));
        if (sizeof($list) != 0) {
            for ($i = 0; $i < sizeof($list); $i++) {
                echo "v" . $list[$i] . "; ";
            }
        } else{
            echo "Немає висячих вершин";
        }
    }?>
</div>
<div class="block-style">
    <?php if (!empty($_POST['dist-reach'])){?>
    <h4 class="text-style">Матриця відстаней D:</h4>
    <?php
    printMatrix(getDistanceMatrix($contMatrix, $size));
    ?>
    <h4 class="text-style">Матриця досяжності R:</h4>
    <?php
    printMatrix(getReachableMatrix($contMatrix, $size));
    }
    if (!empty($_POST['cycles'])){?>
    <h4 class="text-style">Навність простих циклів:</h4>
    <?php
    if (isCyclesExit($contMatrix, $size) == true){
        $cycleList = findCycles(getDistanceMatrix($contMatrix, sizeof($contMatrix)), $size);
        for ($i = 0; $i < sizeof($cycleList); $i++){
            echo ($i + 1) . ") ";
            for ($f = 0; $f < sizeof($cycleList[$i]); $f++){
                echo $cycleList[$i][$f] . " => ";
            }
            echo $cycleList[$i][0] . "; <br>";
        }
    } else {
        echo "Простих циклів немає";
    }
    ?>
    <?php }?>
</div>
<div class="block-style">
    <?php if (!empty($_POST['cohesion'])){?>
        <h4 class="text-style">Тип зв'язності графу:</h4>
        <?php
        getTypeOfCohesion(getDistanceMatrix($contMatrix, $size), getReachableMatrix($contMatrix, $size), $size);
    }?>
</div>


<?php
echo "<br>";
echo "<br>";
//printMatrix(getSymetricContiguityMatrix($contMatrix, $vertexCount));
$symetricContMatrix = getSymetricContiguityMatrix($contMatrix, $vertexCount);

$detour = [];
$detour[0]['vertex'] = 1;
$detour[0]['dfs_num'] = 1;
$detour[0]['stack'][0] = 0;?>

<div class="block-style">
    <?php if (!empty($_POST['dfs_method'])){?>
    <h4 class="text-style">Протокол обходу вглиб:</h4>
    <?php doWideDetour($symetricContMatrix, $detour);?>
    <div class="block-style" style="margin-right: 30px">
        <p>вершина</p>
        <?php for ($i = 0; $i < count($detour); $i++){
            echo $detour[$i]['vertex'] . "<br>";
    }?>
    </div>
    <div class="block-style" style="margin-right: 30px">
        <p>dfs-номер</p>
        <?php for ($i = 0; $i < count($detour); $i++){
            echo $detour[$i]['dfs_num'] . "<br>";
        }?>
    </div>
    <div class="block-style" style="margin-right: 30px">
        <p>стек</p>
        <?php for ($i = 0; $i < count($detour) - 1; $i++){
            for ($j = 0; $j < count($detour[$i]['stack']); $j++){
                    echo $detour[$i]['stack'][$j] + 1 . " ";
            }
            echo "<br>";
        }
        echo "∅";?>
    </div>
    <?php }?>
</div>

<?php

echo "<pre>";
$depthDetour = [];
$depthDetour[0]['vertex'] = 1;
$depthDetour[0]['bfs_num'] = 1;
$depthDetour[0]['stack'][0] = 0;
//doDepthDetour($contMatrix, $depthDetour);
//var_dump($depthDetour);
echo "</pre>";

//$m = array([1, 0, 1], [0, 1, 1], [1, 0, 0]);

?>

<div class="block-style">
    <?php if (!empty($_POST['bfs_method'])){?>
        <h4 class="text-style">Протокол обходу вшир:</h4>
        <?php doDepthDetour($contMatrix, $depthDetour);?>
        <div class="block-style" style="margin-right: 30px">
            <p>вершина</p>
            <?php for ($i = 0; $i < count($depthDetour); $i++){
                echo $depthDetour[$i]['vertex'] . "<br>";
            }?>
        </div>
        <div class="block-style" style="margin-right: 30px">
            <p>bfs-номер</p>
            <?php for ($i = 0; $i < count($depthDetour); $i++){
                echo $depthDetour[$i]['bfs_num'] . "<br>";
            }?>
        </div>
        <div class="block-style" style="margin-right: 30px">
            <p>черга</p>
            <?php for ($i = 0; $i < count($depthDetour) - 1; $i++){
                for ($j = 0; $j < count($depthDetour[$i]['stack']); $j++){
                    echo $depthDetour[$i]['stack'][$j] + 1 . " ";
                }
                echo "<br>";
            }
            echo "∅";?>
        </div>
    <?php }?>
</div>


<?php

echo "<pre>";
$depthDetour = [];
$depthDetour[0]['vertex'] = 1;
$depthDetour[0]['dfs_num'] = 1;
$depthDetour[0]['stack'][0] = 0;
//doDepthDetour($contMatrix, $depthDetour);
//var_dump($depthDetour);
echo "</pre>";

//$m = array([1, 0, 1], [0, 1, 1], [1, 0, 0]);

?>
</body>
</html>