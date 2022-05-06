<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

if (isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location:member.php");
}

//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];

    $member->delete($id);
    header("location:member.php");
}

if (isset($_POST['update'])) {
    
    //memanggil add
    $member->update($_POST);
    header("location:member.php");
}

$data = null;
$no = 1;

while (list($nim, $nama, $jurusan) = $member->getResult()) {
    
    $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $nim . "</td>
            <td>" . $nama . "</td>
            <td>" . $jurusan . "</td>
            <td>
            <a href='member.php?id_edit=" . $nim .  "' class='btn btn-warning''>Edit</a>
            <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger''>Hapus</a>
            </td>
            </tr>";
    
}


$tpl = new Template("templates/member.html");
$tpl->replace("DATA_TABEL", $data);

$nim_form = null;
$nama_form = null;
$jurusan_form = null;
$button_form = null;
$title_form = null;

if (!empty($_GET['id_edit'])) {

    $title_form .= 'Update Member';
    $tpl->replace("title_form", $title_form);
    
    $id = $_GET['id_edit'];
    $nim_form .= '<input type="hidden" name="tnim" value="'. $id .'">
                    <label for="nim">'. $id .'</label>';
    $tpl->replace("NIM_Form", $nim_form);

    $member->set($id);
    $hasil = $member->getResult();

    $nama_form = '<input type="text" class="form-control" name="tnama" value="'. $hasil["nama"] .'" required />';
    $tpl->replace("Nama_Form", $nama_form);

    $jurusan_form = '<input type="text" class="form-control" name="tjurusan" value="'. $hasil["jurusan"] .'" required />';
    $tpl->replace("Jurusan_Form", $jurusan_form);

    $button_form = '<br><button type="submit" name="update" class="btn btn-primary">Update</button>';
    $tpl->replace("Button_Form", $button_form);
} else {

    $title_form .= 'Input Member';
    $tpl->replace("title_form", $title_form);

    $nim_form .= '<input type="text" class="form-control" name="tnim" required />';
    $tpl->replace("NIM_Form", $nim_form);

    $nama_form = '<input type="text" class="form-control" name="tnama" required />';
    $tpl->replace("Nama_Form", $nama_form);

    $jurusan_form = '<input type="text" class="form-control" name="tjurusan" required />';
    $tpl->replace("Jurusan_Form", $jurusan_form);

    $button_form = '<br><button type="submit" name="add" class="btn btn-primary">Add</button>';
    $tpl->replace("Button_Form", $button_form);
}

$member->close();
$tpl->write();
