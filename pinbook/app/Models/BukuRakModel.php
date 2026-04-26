<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuRakModel extends Model
{
    protected $table = 'buku_rak';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_buku', 'id_rak'];
    
}