<?php
class BaseModel {
    protected $pdo;
    protected $tabela;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
}
