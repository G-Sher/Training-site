function genCert (){
var username =  "username"; 
var myWindow = window.open("","","scrollbars=0,resizable=0");

var contents = "<!doctype html><html><head><style>@media print{ @page { margin: auto;} .name{width:875px; top:275px ;} header, nav, footer {display: none;} .button {border: none;color: white;padding: 15px 32px;text-align: center; text-decoration: none;display: inline-block;font-size: 16px;} .name {-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;    user-select: none;}input {border: 0px;} .container  {width:98%; height:98%;}} .name{font-family:old english text MT;font-size:6em;font-weight:400; color:blue;text-align:center; z-index:10;position:fixed;top:265px;width:100%;} img{width:95%; margin:auto; position:fixed;}</style></head><body class='landScape'><div class='name'>"+username+"</div >"; 
contents+="</body><form id='print'><input type='button'  value='Print Certificate' onClick='printPage()'></form><img src = '../capture.png'></html>";
contents+="<script>function printPage() {document.getElementById('print').style.visibility = 'hidden';window.print();}</script>";
myWindow.document.write(contents);
}