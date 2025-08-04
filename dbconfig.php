<?php
const DB_HOST = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";
const DB_NAME = "moduleconnexion";

//TODO error handling
$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
