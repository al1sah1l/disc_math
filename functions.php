<?php

function getIncidenceMatrix($array, $vertexCount, $ribsCount)
{
    $matrix = array();
    for ($i = 0; $i < $vertexCount; $i++) {

        for ($j = 0; $j < $ribsCount; $j++) {

            if ($i == $array[$j][0] - 1) {
                $matrix[$i][$j] = -1;
            } elseif ($i == $array[$j][1] - 1){
                $matrix[$i][$j] = 1;
            } else {
                $matrix[$i][$j] = 0;
            }
            if ($array[$j][0] == $array[$j][1] && $i + 1 == $array[$j][1]){
                $matrix[$i][$j] = 2;
            }
        }
    }
    return $matrix;
}

function getContiguityMatrix($array, $vertexCount, $ribsCount)
{
    $matrix = array();
    for ($i = 0; $i < $vertexCount; $i++) {
        for ($j = 0; $j < $vertexCount; $j++) {
            for ($d = 0; $d < $ribsCount; $d++) {
                if ($array[$d][0] == $i + 1 && $array[$d][1] == $j + 1) {
                    $matrix[$i][$j] = 1;
                    break;
                } else {
                    $matrix[$i][$j] = 0;
                }
            }
        }
    }
    return $matrix;
}

function printMatrix($matrix)
{?>
    <div style="border-right: 2px solid grey; border-left: 2px solid grey; padding: 0 5px; width: max-content; text-align: center">
    <?php for ($i = 0; $i < sizeof($matrix); $i++) {
        for ($j = 0; $j < sizeof($matrix[$i]); $j++)
        {?>
            <div style="display: inline-block; width: 25px">
            <?php echo $matrix[$i][$j];?>
            </div>
        <?php }
        echo "<br>";
    }?>
    </div>
<?php }

function getGeneralPowerOfVertexes($incMatrix)
{
    $powerList = [];

    for ($i = 0; $i < sizeof($incMatrix); $i++)
    {
        $power = 0;
        for ($f = 0; $f < sizeof($incMatrix[$i]); $f++)
        {
            $power += abs($incMatrix[$i][$f]);
            //echo "Power is " . $power . "<br>";
        }
        $powerList[$i] = [$i + 1, $power];
    }
    return $powerList;
}

function getOutPower($contMatrix)
{
    $powerOutList = array();

    for ($i = 0; $i < sizeof($contMatrix); $i++)
    {
        $power = 0;
        for ($f = 0; $f < sizeof($contMatrix[$i]); $f++)
        {
            $power += $contMatrix[$i][$f];
            //echo "Power is " . $power . "<br>";
        }
        $powerOutList[$i] = [$i + 1, $power];
    }
    return $powerOutList;
}

function getInPower($contMatrix)
{
    $powerInList = array();

    for ($i = 0; $i < sizeof($contMatrix); $i++)
    {
        $power = 0;
        for ($f = 0; $f < sizeof($contMatrix[$i]); $f++)
        {
            $power += $contMatrix[$f][$i];
        }
        $powerInList[$i] = [$i + 1, $power];
    }

    return $powerInList;
}

function writeList($powerList, $num)
{
    for ($i = 0; $i < sizeof($powerList); $i++)
    {?>
        <div style="height: 40px">
            <?php switch ($num){
                case 1: ?>
                    <p class="vertex-list"><?php echo  "v" . ($i + 1) . " - "?></p>
                    <p style="width: max-content; display: inline-block"><?php echo $powerList[$i][1] . " степінь <br>";?></p>
            <?php break;
                case 2:?>
                    <p class="vertex-list"><?php echo  "d-(v" . ($i + 1) . ") = "?></p>
                    <p style="width: max-content; display: inline-block"><?php echo $powerList[$i][1] . " півстепінь <br>";?></p>
            <?php break;
                case 3:?>
                    <p class="vertex-list"><?php echo  "d+(v" . ($i + 1) . ") = "?></p>
                    <p style="width: max-content; display: inline-block"><?php echo $powerList[$i][1] . " півстепінь <br>";?></p>
            <?php break;
            }?>
        </div>
    <?php }
}

function isSmooth($list)
{
    $i = 1;
    while ($list[$i-1][1] != $list[$i][1]){
        $i++;
    }
    if ($i - 1 == sizeof($list)){
        return true;
    }
}

function findHangingVertexes($powers)
{
    $hangingList = array();
    $count = 0;

    for ($i = 0; $i < sizeof($powers); $i++){
        if ($powers[$i][1] == 1){
            $hangingList[$count] = $i + 1;
            $count++;
        }
    }

    return$hangingList;
}

function findIsolatedVertexes($powers)
{
    $isolatingList = array();
    $count = 0;

    for ($i = 0; $i < sizeof($powers); $i++){
        if ($powers[$i][1] == 0){
            $isolatingList[$count] = $i + 1;
            $count++;
        }
    }

    return$isolatingList;
}

function getPoweredMatrix($matrix, $power)
{
    $newMatrix = [];
    if ($power > 1){
        for ($i = 0; $i < sizeof($matrix); $i++){
            for ($f = 0; $f < sizeof($matrix[$i]); $f++){
                $temp = 0;
                for ($d = 0; $d < sizeof($matrix[$i]); $d++){
                    $temp += $matrix[$i][$d] * getPoweredMatrix($matrix, $power - 1)[$d][$f];
                }
                $newMatrix[$i][$f] = $temp;
            }
        }
        return $newMatrix;
    } else{
        return $matrix;
    }
}

function multiplyMatrixes($matrix1, $matrix2)
{
    $result = [];
    for ($i = 0; $i < sizeof($matrix1); $i++){
        for ($f = 0; $f < sizeof($matrix1[$i]); $f++){
            $temp = 0;
            for ($d = 0; $d < sizeof($matrix1[$i]); $d++){
                $temp += $matrix1[$i][$d] * $matrix2[$d][$f];
            }
            $result[$i][$f] = $temp;
        }
    }
    return $result;
}

function getDistanceMatrix($contMatrix, $size)
{
    $newMatrix = $contMatrix;
    $distanceMatrix = [];
    for ($i = 0; $i < $size; $i++){
        for ($f = 0; $f < $size; $f++){
            if ($contMatrix[$i][$f] == 1) {
                $distanceMatrix[$i][$f] = 1;
            } else {
                $distanceMatrix[$i][$f] = "inf";
            }
        }
    }

    for ($p = 1; $p <= $size; $p++){
        $temp = $newMatrix;
        $newMatrix = multiplyMatrixes($temp, $contMatrix);

        for ($i = 0; $i <  $size; $i++){
            for ($f = 0; $f <  $size; $f++){
                if ($distanceMatrix[$i][$f] == "inf" && $newMatrix[$i][$f] > 0) {
                    $distanceMatrix[$i][$f] = $p + 1;
                }
                if ($i == $f){
                    $distanceMatrix[$i][$f] = 0;
                }
            }
        }
    }
    return $distanceMatrix;
}

function getReachableMatrix($contMatrix, $size)
{
    $newMatrix = $contMatrix;
    $reachableMatrix = [];
    for ($i = 0; $i < $size; $i++){
        for ($f = 0; $f < $size; $f++){
            if ($contMatrix[$i][$f] == 1) {
                $reachableMatrix[$i][$f] = 1;
            } else {
                $reachableMatrix[$i][$f] = 0;
            }
        }
    }

    for ($p = 1; $p < $size; $p++){
        $temp = $newMatrix;
        $newMatrix = multiplyMatrixes($temp, $contMatrix);
        for ($i = 0; $i < $size; $i++){
            for ($f = 0; $f < $size; $f++){
                if ($i == $f){
                    $reachableMatrix[$i][$f] = 1;
                }

                if ($reachableMatrix[$i][$f] == 0 && $newMatrix[$i][$f] > 0) {
                    $reachableMatrix[$i][$f] = 1;
                }
            }
        }
    }
    return $reachableMatrix;
}

function isCyclesExit($contMatrix, $size)
{
    $matrix = [];
    $newMatrix = $contMatrix;
    for ($i = 0; $i < $size; $i++){
        for ($f = 0; $f < $size; $f++){
            $matrix[$i][$f] = 0;
        }
    }

    for ($p = 1; $p < $size; $p++){
        $temp = $newMatrix;
        $newMatrix = multiplyMatrixes($temp, $contMatrix);
        for ($i = 0; $i < $size; $i++){
            for ($f = 0; $f < $size; $f++){
                if ($matrix[$i][$f] == 0 && $newMatrix[$i][$f] > 0) {
                    $matrix[$i][$f] = 1;
                }
            }
        }
    }

    for ($i = 0; $i < $size; $i++){
        if ($matrix[$i][$i] == 1){
            return true;
        }
    }

    return false;
}

function findCycles($distMatrix, $size){

    $temp = [];
    $cycles = [];
    for ($i = 0; $i < $size; $i++){
        $temp[$i][0] = $i + 1;
        $num = 1;
        $d = 1;
        for ($f = 0; $f < $size; $f++){
            if ($distMatrix[$i][$f] == $num){
                $temp[$i][$d] = $f + 1;
                $d++; $num++; $f = -1;
            }
            if ($distMatrix[$f][$i] == 1){
                $cycles[$i] = $temp[$i];
            }
        }
    }
    return $cycles;
}

function transformMatrix($matrix, $size){
    $transformed = [];
    for ($i = 0; $i < $size; $i++){
        for ($f = 0; $f < $size; $f++){
            $transformed[$i][$f] = $matrix[$f][$i];
        }
    }
    return $transformed;
}

function getTypeOfCohesion($distanceMatrix, $reachableMatrix, $size)
{
    $tempMatrix = [];
    for ($i = 0; $i < $size; $i++){
        for ($f = 0; $f < $size; $f++){
            $tempMatrix[$i][$f] = 0;
        }
    }

    $identityMatrix = [];
    for ($i = 0; $i < $size; $i++){
        for ($f = 0; $f < $size; $f++){
            $identityMatrix[$i][$f] = 1;
        }
    }

    if ($reachableMatrix == $identityMatrix){
        echo "Сильно-зв'язний граф";
        return "strong";
    }

    for ($i = 0; $i < $size; $i++){
        for ($f = 0; $f < $size; $f++){
            if ($reachableMatrix[$i][$f] == 1 || transformMatrix($reachableMatrix, $size)[$i][$f]){
                $tempMatrix[$i][$f] = 1;
            }
        }
    }

    if ($tempMatrix == $identityMatrix){
        echo "Однобічно-зв'язний граф";
        return "unilateral";
    }

    $pointer = 0;
    for ($i = 0; $i < $size; $i++){
        $count = 0;
        for ($f = 0; $f < $size; $f++){
            if ($distanceMatrix[$f][$i] == 0 || $distanceMatrix[$f][$i] == "inf"){
                $count++;
            }
        }
        if ($count == $size){
           $pointer++;
        }
    }
    if ($pointer > 1){
        echo "Слабо-зв'язний граф";
        return "weak";
    }
    echo "Незв'язний граф";
    return "undefined";
}

function getSymetricContiguityMatrix($contMatrix, $vertexCount)
{
    $matrix = array();
    for ($i = 0; $i < $vertexCount; $i++) {
        for ($j = 0; $j < $vertexCount; $j++) {
            $matrix[$i][$j] = 0;
        }
    }

    for ($i = 0; $i < $vertexCount; $i++) {
        for ($j = 0; $j < $vertexCount; $j++) {
            if ($contMatrix[$i][$j] == 1) {
                $matrix[$i][$j] = 1;
                $matrix[$j][$i] = 1;
            }
        }
    }
    return $matrix;
}

const INDEX_UNDEFINED_VERTEX = -1;

function findVertex($matrixString, $startPoint)
{
    $vertexCount = count($matrixString);
    for ($i = $startPoint; $i < $vertexCount; $i++) {
        if ($matrixString[$i]){
            return $i;
        }
    }
    return INDEX_UNDEFINED_VERTEX;
}

function doWideDetour($contMatrix, &$detour)
{
    $dfs = 1;
    $memoryIndex = [];

    for ($i = 0; $i < count($contMatrix); $i++){
        $memoryIndex[] = 0;
    }

    while (!empty($detour[count($detour) - 1]['stack'])){

        $listLastIndex = count($detour) - 1;
        $lastDetour = $detour[$listLastIndex];
        $stackLastIndex = count($lastDetour['stack']) - 1;
        $lastElementOfStack = $lastDetour['stack'][$stackLastIndex];

        $vert = findVertex($contMatrix[$lastElementOfStack], $memoryIndex[$lastElementOfStack]);

        if ($vert > INDEX_UNDEFINED_VERTEX){

            if (in_array($vert, $lastDetour['stack'])){

                $memoryIndex[$lastElementOfStack] = $vert + 1;
                continue;
            }

            $newStack = array_merge($lastDetour['stack'], [$vert]);
            $memoryIndex[$lastElementOfStack]++;

            $newRowDetour = [
                'vertex' => $vert + 1,
                'dfs_num' => ++$dfs,
                'stack' => $newStack,
            ];

            $detour[] = $newRowDetour;
        } else {
            array_splice($lastDetour['stack'], $stackLastIndex, 1);
            array_splice($memoryIndex, $stackLastIndex, 1);
            $memoryIndex[$lastElementOfStack - 1]++;
            $newRowDetour = [
                'vertex' => "-",
                'dfs_num' => "-",
                'stack' => $lastDetour['stack'],
            ];

            $detour[] = $newRowDetour;
        }
    }
    $listLastIndex = count($detour) - 1;
    $detour[$listLastIndex]['stack'] = 0;

    return $detour;
}

function doDepthDetour($contMatrix, &$detour)
{
    $bfs = 1;
    $memoryIndex = [];

    for ($i = 0; $i < count($contMatrix); $i++){
        $memoryIndex[] = 0;
    }

    while (!empty($detour[count($detour) - 1]['stack'])){

        $listLastIndex = count($detour) - 1;
        $lastDetour = $detour[$listLastIndex];
        $firstElementOfStack = $lastDetour['stack'][0];

        $vert = findVertex($contMatrix[$firstElementOfStack], $memoryIndex[$firstElementOfStack]);

        if ($vert > INDEX_UNDEFINED_VERTEX){

            if (in_array($vert, $lastDetour['stack'])){
                $memoryIndex[$firstElementOfStack] = $vert + 1;
                continue;
            }

            $newStack = array_merge($lastDetour['stack'], [$vert]);
            $memoryIndex[$firstElementOfStack] = 0;

            $newRowDetour = [
                'vertex' => $vert + 1,
                'bfs_num' => ++$bfs,
                'stack' => $newStack,
                //'memory' => $memoryIndex,
            ];
            $detour[] = $newRowDetour;
        } else {
            array_splice($lastDetour['stack'], 0, 1);
            //array_splice($memoryIndex, 0, 1);

            $newRowDetour = [
                'vertex' => "-",
                'bfs_num' => "-",
                'stack' => $lastDetour['stack'],
                //'memory' => $memoryIndex,
            ];

            $detour[] = $newRowDetour;
        }
    }

    return $detour;
}