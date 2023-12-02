<?php 

function formatMoneyVN($money){
    return number_format($money, 0, ',', '.') . ' VNĐ';
}