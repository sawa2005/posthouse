<?php
// Kontrollerar om variabeln finns
if (isset($_POST['task'])) {
    $tasks = [$_POST['task']];

    $jsonData = json_encode($tasks, JSON_PRETTY_PRINT);
    
    //Skriv till JSON-fil
    file_put_contents('tasks.json', $jsonData);
}

//Läsa in JSON-fil
$jsonFile = file_get_contents('tasks.json');
$oldTasks = json_decode($jsonFile, true);

foreach ($oldTasks as $oldTask) {
    echo '<article><p>'.$oldTask.'</p>
    <button id="done">Klar</button></article>';
}

class Task {
    public $task;
    
    public function __construct(string $task) {
        $this->task = $task;
        $result = '<article><p>'.$this->task.'</p>
        <button id="done">Klar</button></article>';
        echo $result;
        
        $jsonArr = array_push($oldTasks, $_POST['desc']);
        $jsonData = json_encode($jsonArr, JSON_PRETTY_PRINT);
        
        //Skriv till JSON-fil
        file_put_contents('tasks.json', $jsonData);
    }
}

$task1 = new Task($_POST['desc']);
?>