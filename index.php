<html>
<head>
<meta charset="UTF-8">
<title>Contracts Data</title>
</head>
<body>
<?php
    $file = fopen("files/contracts.csv","r");

    if ($file !== FALSE) {
        $key=0;                 //row variable for contracts
        while (($record = fgetcsv($file)) !== FALSE) {
            $count=count($record);          //column variable for contracts
            for ($i=0; $i < $count; $i++) {
                $contract_data[$key][$i] = $record[$i];
            }
            $key++;
        }
    }

    $file1 = fopen("files/awards.csv","r");

    if ($file1 !== FALSE) {
        $key1=0;                    //row variable for awards
        while (($record = fgetcsv($file1)) !== FALSE) {
            $count1=count($record);         //column variable for awards
            for ($i=0; $i < $count1; $i++) {
                $award_data[$key1][$i] = $record[$i];
            }
            $key1++;
        }
    }

    $count2=$count+$count1-1;

    for ($row=0;$row<$key;$row++){                    //Set the initial value of output_data to empty
        for($col=0;$col<$count2;$col++){
            $output_data[$row][$col]='';
        }
    }

    for($i=0;$i<$count;$i++){                               //Set fieldnames from contracts
        $output_data[0][$i]=$contract_data[0][$i];
    }

    for($i=$count;$i<$count2;$i++){                         //Set fieldnames from awards
        $output_data[0][$i]=$award_data[0][$i-$count+1];
     }

    for ($row=1;$row<$key;$row++){
        for ($i=1;$i<$key1;$i++){
            if ($contract_data[$row][0]==$award_data[$i][0]){               //Check for same contract name from both files
                for($col=0;$col<$count2;$col++){
                    if ($col<$count)
                        {$output_data[$row][$col]=$contract_data[$row][$col];}
                    else
                        {$output_data[$row][$col]=$award_data[$i][($col-$count)+1];}
                }
            }
            else{
                for($col=0;$col<$count;$col++){
                    $output_data[$row][$col]=$contract_data[$row][$col];
                }
            }
        }
    }
    $amount=0;
    for($i=0;$i<$key;$i++){
        if($output_data[$i][1]=='Current'&& $output_data[$i][12]!=''){          //find total amount 
            $amount=$amount+$output_data[$i][12];
        }
    }

    echo 'Total Amount of current contracts: ', $amount;

    $fp = fopen('files/final.csv', 'w');

    foreach ($output_data as $fields) {             //write output_data to final.csv
        fputcsv($fp, $fields);
    }

    fclose($fp);
    fclose($file);
    fclose($file1);
?>
</body>
</html>
