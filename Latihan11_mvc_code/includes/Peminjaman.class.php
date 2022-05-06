<?php

class Peminjaman extends DB
{
    function getPinjam()
    {
        $query = "SELECT * FROM peminjaman";
        return $this->execute($query);
    }

    function add($data)
    {
        $buku = $data['tbuku'];
        $member = $data['tmember'];
        $status = "Belum Dikembalikan";

        $query = "insert into peminjaman values ('', '$buku', '$member', '$status')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM peminjaman WHERE id_pinjam = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function statusPinjam($id)
    {

        $status = "Telah Dikembalikan";
        $query = "update peminjaman set status = '$status' where id_pinjam = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}


?>