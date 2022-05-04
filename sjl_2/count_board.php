<?php
    include_once "db/db.php";

    $conn = get_conn();
    $YY = date('y');
    $MM = date('m');
    $DD = date('d');
    $dat = $YY."-".$MM."-".$DD;
    //오늘 날짜 정보를 DB에서 조회한다.
    $sql = "SELECT * FROM count_db where redate = '$dat'";

    $result = mysqli_query($conn,$sql);
    $list = mysqli_num_rows($result);
    //결과집합을 받아온다

    if(!$list) // 아무도 들어온 적이 없을 경우
    {
        $count = 0;
    }
    else
    {
        $row = mysqli_fetch_array($result);
        $count = $row['COUNT'];
    }

    if($count === 0)
    { //오늘 날짜로 새로운 count 값을 추가한다
        $count++;
        $sql = "INSERT INTO count_db 
        values
        ('$count','$dat')";
    }
    else
    {// 오늘 날짜의 기존 count 값을 변경시킨다
        $count++;
        $sql = "UPDATE count_db 
        set count = '$count' 
        where redate = '$dat'";
    }

    mysqli_query($conn,$sql);
    //총 조회수
    $totalQurey = "SELECT SUM(count) as cnt FROM count_db";
    $totalCount = mysqli_fetch_assoc(mysqli_query($conn,$totalQurey))['cnt'];
    mysqli_close($conn);

    echo "<br><center><h2> 방문자 수 통계입니다. </h2><hr>";
    echo "[ Today : <font color = red>";
    echo "${count}명 ]";
    echo "</font> <br>";

    echo "[ Total : <font color = blue>";
    echo "${totalCount}명 ]";
    echo "</font> <br>";
    
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>방문자수 통계</title>
</head>
<body>
    
</body>
</html>