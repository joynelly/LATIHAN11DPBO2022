<?php

class Member extends DB
{
    function getMember()
    {
        $query = "SELECT * FROM member";
        return $this->execute($query);
    }

    function add($data)
    {
        $nim = $data['tnim'];
        $nama = $data['tnama'];
        $jurusan = $data['tjurusan'];

        $query = "insert into member values ('$nim', '$nama', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM member WHERE nim = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function set($id)
    {
        $query = "SELECT * FROM member WHERE nim= '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($data)
    {
        $nim = $data['tnim'];
        $nama = $data['tnama'];
        $jurusan = $data['tjurusan'];

        $query = "update member set nama = '$nama', jurusan = '$jurusan' where nim = '$nim'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
