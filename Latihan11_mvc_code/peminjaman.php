<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Peminjaman.class.php");
include("includes/Buku.class.php");
include("includes/Member.class.php");

$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$member = new Member($db_host, $db_user, $db_pass, $db_name);
$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$buku->open();
$member->open();
$peminjaman->open();
$buku->getBuku();
$member->getMember();
$peminjaman->getPinjam();

$status = false;
$alert = null;

if (isset($_POST['add'])) {
    //memanggil add
    $peminjaman->add($_POST);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];

    $peminjaman->delete($id);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil add
    $id = $_GET['id_edit'];

    $peminjaman->statusPinjam($id);
    header("location:peminjaman.php");
}

$data = null;
$dataBuku = null;
$dataMember = null;
$no = 1;

while (list($id, $id_buku, $id_member, $status) = $peminjaman->getResult()) {
    if ($status == "Telah Dikembalikan") {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $id_buku . "</td>
            <td>" . $id_member . "</td>
            <td>" . $status . "</td>
            <td>
            <a href='peminjaman.php?id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
    else {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $id_buku . "</td>
            <td>" . $id_member . "</td>
            <td>" . $status . "</td>
            <td>
            <a href='peminjaman.php?id_edit=" . $id .  "' class='btn btn-warning' '>Kembalikan</a>
            <a href='peminjaman.php?id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
}

while (list($id, $judul, $penerbit, $deskripsi, $status, $id_author) = $buku->getResult()) {
    $dataBuku .= "<option value='".$id."'>".$judul."</option>
                ";
}

while (list($id, $nama, $jurusan) = $member->getResult()) {
    $dataMember .= "<option value='".$id."'>".$nama."</option>
                ";
}

$member->close();
$buku->close();
$peminjaman->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("OPTION_BUKU", $dataBuku);
$tpl->replace("OPTION_MEMBER", $dataMember);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
