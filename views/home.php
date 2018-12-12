<?php require_once('../views/header.php'); ?>

<html>
    <head>
    </head>
    <body>
        <div id="home">
            <a href="/Fight"><img id="fight" src="/images/main-symbol.jpg" alt="CRASH SOME NUTS"></a>
            <div>
            <div id="player_stats">
                <div class="stat_block">
                    Playername
                </div>
                <div class="stat_block">
                    <div class="player_stats">
                        Games: <?= $stats['TotalGames'] ?>
                    </div>
                    <div class="player_stats">
                        Wins: <?= $stats['Wins'] ?>
                    </div>
                    <div class="player_stats">
                        Win Ratio: <?php
                            if($stats['TotalGames'] > 0){
                                echo ($stats['Wins'] / $stats['TotalGames']);
                            }else{
                                echo '0';
                            }
                        
                        ?>
                    </div>
                </div>
                
            </div>
            <div id="fighter_info">
                <a href="/Fighter"><img id="fighter_pic" src="/images/edit_fighter.png" alt="much edit such fighter"></a>
            </div>
            </div>
        </div>
    </body>
</html>