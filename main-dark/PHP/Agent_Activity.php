<?php
    /*
	"Top Agents Staffed:";1;"Split/Skill:";"BRILIFE INBOUND INA"
	"Top Agents Avail:";1
	"Skill State:";"NORMAL"
	"Top Agents Ringing:";0
	"Calls Waiting:";0
	"Top Agents on ACD Calls:";0
	"Oldest Call Waiting:";0;"Top Agents in ACW:";0
	"Top Agents in AUX:";0
	"Direct Agent Calls Waiting:";0
	"Top Agents in Other:";0
	"% Within Service Level:";0
	"Service Level:";0;"Flex Agents Staffed:";0
	"ACD Calls:";1;"Reserve1 Agents Staffed:";0
	"Aban Calls:";0;"Reserve2 Agents Staffed:";0
	"";"Agent Name";"Login ID";"Extn";"AUX Reason";"State";"Split/Skill";"Level";"Time";"VDN Name"
	2;"Agent01";"5701";"4704";"";"AVAIL";0;"";25;""
	*/
	
	$string = file_get_contents("AgentActivity.txt");
$baris = preg_split('/\r\n|\n|\r/', trim($string));

$data = [];
foreach ($baris as $key => $value) {
    // Skip the first two lines
    if ($key < 2) continue;

    // Process Head data (rows 3-15 in the file)
    if ($key <= 14) { 
        $items = explode(";", filter($value));
        $item_value = array_splice($items, 1);
        $data['Head'][] = $item_value; // Store all rows in Head as individual arrays
    } else {
        // Process DataDetail starting from row 16
        $items = explode(";", filter($value));
        
        if ($key == 15) { 
            $groups = $items;
        } else {
            $detail = [];
            for ($i = 1; $i < count($items); $i++) { 
                $detail[filter($groups[$i])] = filter($items[$i]);
            }
            $data['DataDetail'][] = $detail;
        }
    }
}

function filter($teks)
{
    return trim(preg_replace('/\s+/', ' ', preg_replace("/[^A-Za-z0-9\ \;]/", " ", $teks)));
}

echo json_encode($data);