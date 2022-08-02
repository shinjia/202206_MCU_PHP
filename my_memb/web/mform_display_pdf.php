<?php
/* my_form v0.1  @Shinjia  #2022/07/30 */
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION[DEF_SESSION_USERTYPE]) ? $_SESSION[DEF_SESSION_USERTYPE] : '';
$ss_usercode = isset($_SESSION[DEF_SESSION_USERCODE]) ? $_SESSION[DEF_SESSION_USERCODE] : '';

$a_valid_usertype = array(DEF_LOGIN_MEMBER, DEF_LOGIN_VIP);  // 可以使用本網頁的權限

if(!in_array($ss_usertype, $a_valid_usertype)) {
    header('Location: login_error.php');
    exit;
}

//==============================================================================

// 接收傳入變數
$formcode = isset($_GET['formcode']) ? $_GET['formcode'] : 0;

// 網頁內容預設
$ihc_content = '';
$ihc_error = '';

// 連接資料庫
$pdo = db_open();

// SQL 語法
$sqlstr = "SELECT * FROM mform_vw ";
$sqlstr .= "WHERE formcode=? && membcode=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $formcode   , PDO::PARAM_STR);
$sth->bindValue(2, $ss_usercode, PDO::PARAM_STR);

// 執行 SQL
try {
    $sth->execute();
    
    if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $membcode = html_encode($row['membcode']);
        $membname = html_encode($row['membname']);
        $formcode = html_encode($row['formcode']);
        $formname = html_encode($row['formname']);
        $formdate = html_encode($row['formdate']);
        $formfld1 = html_encode($row['formfld1']);
        $formfld2 = html_encode($row['formfld2']);
        $forminfo = html_encode($row['forminfo']);

        // 注意：TCPDF 不支援 CSS，格式以 HTML 為主
        $data = <<< HEREDOC
        <p>會員代號：{$membcode}</p>
        <p>會員姓名：{$membname}</p>
        <hr>
        <h3>表單</h3>
        <table border="1" cellpadding="3" cellspacing="0">
            <tr><th width="10%">代碼</th><td width="90%">{$formcode}</td></tr>
            <tr><th width="10%">主旨</th><td width="90%">{$formname}</td></tr>
            <tr><th width="10%">日期</th><td width="90%">{$formdate}</td></tr>
            <tr><th width="10%">欄一</th><td width="90%">{$formfld1}</td></tr>
            <tr><th width="10%">欄二</th><td width="90%">{$formfld2}</td></tr>
            <tr><th width="10%">更多</th><td width="90%">{$forminfo}</td></tr>
        </table>
HEREDOC;

        // 網頁內容
        $ihc_content = <<< HEREDOC
        {$data}
HEREDOC;
    }
    else {
        $ihc_content = '<p class="center">查不到相關記錄！</p>';
    }
}
catch(PDOException $e) {
    // db_error(ERROR_QUERY, $e->getMessage());
    $ihc_error = error_message('ERROR_QUERY', $e->getMessage());
}

db_close();

//網頁顯示
$html = <<< HEREDOC
<h2>會員的申請表單</h2>
{$ihc_content}
{$ihc_error}
HEREDOC;

// include 'pagemake.php';
// pagemake($html);

// 輸出為 PDF
require_once('../class/tcpdf/examples/lang/zho.php');
require_once('../class/tcpdf/tcpdf.php');

//實體化PDF物件
$pdf = new TCPDF("P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false); //不要頁首
$pdf->setPrintFooter(false); //不要頁尾

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);  //設定自動分頁

$pdf->setLanguageArray($l); //設定語言相關字串

$pdf->setFontSubsetting(true); //產生字型子集（有用到的字才放到文件中）

//$pdf->SetFont('droidsansfallback', '', 12, '', true); //設定字型
//$pdf->SetFont('msungstdlight', '', 12, '', true); //設定字型

//$pdf->SetFont('cid0jp', '', 12); // 可以顯示中文(繁、簡)、日文、韓文。
//$pdf->SetFont('cid0ct', '', 10); // 
//$pdf->SetFont('msungstdlight', '', 12, '', true); //　繁中, 但是效果不好,字會偏移
//$pdf->SetFont('stsongstdlight', '', 12); // 可以顯示中文, 但是效果不好,字會偏移
//$pdf->SetFont('dejavusans', '', 12, '', true); //　預設 utf8

$pdf->setCellPaddings($left='', $top='', $right ='', $bottom='');
$pdf->setCellPadding(0.2);

$pdf->AddPage(); //新增頁面

$pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));//文字陰影

$pdf->writeHTML($html);

// 增加功能：2D Bar code
// set style for barcode
$style = array(
    'border' => true,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

// 條碼內容
$now = time();
$chk = md5(SYSTEM_CODE.$formcode.$now);  // 自訂編碼規則
$code = URL_ROOT . 'api/mform_display.php?formcode=' . $formcode . '&ts=' . $now . '&chk=' . $chk;

$pdf->write2DBarcode($code, 'QRCODE,M', 180, 20, 80, 80, $style, 'N');
// end of QR Code

$pdf->Output('download.pdf', 'I');
// $pdf->Output('download.pdf', 'D');  // download

?>