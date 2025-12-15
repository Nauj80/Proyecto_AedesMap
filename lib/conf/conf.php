<?php
function connection() {
    return pg_connect
    ("host=localhost 
    dbname=aedesmap 
    user=postgres 
    password=postgres");
}