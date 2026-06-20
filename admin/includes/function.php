<?php

function updateStatistics($pdo)
{
    $today = date('Y-m-d');
    $stmt = $pdo->query("SELECT * FROM statistics");
    $stats = $stmt->fetchAll();

    foreach($stats as $stat)
    {
        if($stat['auto_increment_status'] == 'Yes')
        {
            $lastDate = $stat['last_updated_date'];

            if(empty($lastDate))
            {
                $update = $pdo->prepare("UPDATE statistics SET last_updated_date = ? WHERE id = ?");
                $update->execute([$today, $stat['id']]);
                continue;
            }

            // Logic for Monthly Update (Happy Clients)
            if ($stat['id'] == 1 || $stat['title'] == 'Happy Clients') 
            {
                $d1 = new DateTime($lastDate);
                $d2 = new DateTime($today);
                $interval = $d1->diff($d2);
                
                // Total months passed
                $unitsPassed = ($interval->y * 12) + $interval->m;
            } 
            else 
            {
                // Logic for Daily Update (Everything else)
                $unitsPassed = floor((strtotime($today) - strtotime($lastDate)) / (60 * 60 * 24));
            }

            if($unitsPassed > 0)
            {
                $newCount = $stat['current_count'] + ($stat['daily_increment'] * $unitsPassed);

                $update = $pdo->prepare("
                    UPDATE statistics 
                    SET current_count = ?, last_updated_date = ? 
                    WHERE id = ?
                ");

                $update->execute([$newCount, $today, $stat['id']]);
            }
        }
    }
}
?>