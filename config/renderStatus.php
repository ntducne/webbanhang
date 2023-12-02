<?php 

function renderStatusOrder($status){
    switch ($status) {
        case 0:
            return '<span class="badge bg-secondary">Pending</span>';
            break;
        case 1:
            return '<span class="badge bg-primary">Confirmed</span>';
            break;
        case 2:
            return '<span class="badge bg-success">Delivering</span>';
            break;
        case 3:
            return '<span class="badge bg-warning">Delivered</span>';
            break;
        case 4:
            return '<span class="badge bg-danger">Cancelled</span>';
            break;
        case 5:
            return '<span class="badge bg-success">Received</span>';
            break;
        default:
            return '<span class="badge bg-secondary">Pending</span>';
            break;
    }
}

function renderStatusOrderProfile($status){
    switch ($status) {
        case 0:
            return '<span class="badge bg-secondary">Pending</span>';
            break;
        case 1:
            return '<span class="badge bg-primary">Confirmed</span>';
            break;
        case 2:
            return '<span class="badge bg-success">Delivering</span>';
            break;
        case 3:
            return '<span class="badge bg-warning">Delivered</span>';
            break;
        case 4:
            return '<span class="badge bg-danger">Cancelled</span>';
            break;
        case 5:
            return '<span class="badge bg-success">Received</span>';
            break;
        default:
            return '<span class="badge bg-secondary">Pending</span>';
            break;
    }
}