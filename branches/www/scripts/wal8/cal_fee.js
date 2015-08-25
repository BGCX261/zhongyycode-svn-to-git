// JavaScript Document
var xmlHttp

function cal_fee(str)
{

  xmlHttp=GetXmlHttpObject()

  if (xmlHttp==null)
    {
    alert ("您的浏览器不支持AJAX！");
    return;
    }

  var url="../../common/cal_fee.php";
  url=url+"?fee_p="+str;
  url=url+"&sid="+Math.random();
  xmlHttp.onreadystatechange=stateChanged;
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
}

function stateChanged()
{
    if (xmlHttp.readyState==4)
    {
        var ret =xmlHttp.responseText.split(",");
        if(ret[0] == "ok"){
            for(j = 1; j<25 ; j++ ){
                if(j == ret[1]){
                    document.getElementById("tr" + ret[1]).style.display = "";
                    document.getElementById("fee_need" + ret[1]).value = ret[2];
                    }
                else {
                    document.getElementById("tr" + j).style.display = "none";
                    document.getElementById("tr" + j + "-2").style.display = "none";
                }
            }
        }
        else{
            for(k = 1; k<25 ; k++ ){
                if(k == ret[1]){
                    document.getElementById("tr" + ret[1] + "-2").style.display = "";
                }
                else{
                    document.getElementById("tr" + k).style.display = "none";
                    document.getElementById("tr" + k + "-2").style.display = "none";
                }
            }
        }
    }
}

function GetXmlHttpObject()
{
  var xmlHttp=null;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
return xmlHttp;
}

function paduan() {
  var r = document.getElementsByName("t");
  var isChecked = false;
  for (var i = 0; i < r.length; i++) {
    if (r[i].checked) {
        isChecked = true;
        break;
    }
  }
  return isChecked;
}
function checkForm() {
  if (!paduan()) {
    alert("请选择要升级的类型！");
    return false;
  }
}

var docEle = function()
{
    return document.getElementById(arguments[0]) || false;
}

function openNewDiv(_id,_p)
{
    var m = "mask";
    if (docEle(_id)) document.body.removeChild(docEle(_id));
    if (docEle(m)) document.body.removeChild(docEle(m));

    //mask遮罩层

    var newMask = document.createElement("div");
    newMask.id = m;
    newMask.style.position = "absolute";
    newMask.style.zIndex = "1";
    _scrollWidth = Math.max(document.body.scrollWidth,document.documentElement.scrollWidth);
    _scrollHeight = Math.max(document.body.scrollHeight,document.documentElement.scrollHeight);
    newMask.style.width = _scrollWidth + "px";
    newMask.style.height = _scrollHeight + "px";
    newMask.style.top = "0px";
    newMask.style.left = "0px";
    newMask.style.background = "#33393C";
    newMask.style.filter = "alpha(opacity=40)";
    newMask.style.opacity = "0.40";
    document.body.appendChild(newMask);

    //新弹出层

    var newDiv = document.createElement("div");
    newDiv.id = _id;
    newDiv.style.position = "absolute";
    newDiv.style.zIndex = "9999";
    newDivWidth = 400;
    newDivHeight = 200;
    newDiv.style.width = newDivWidth + "px";
    newDiv.style.height = newDivHeight + "px";
    newDiv.style.top = (document.body.scrollTop + document.body.clientHeight/5 - newDivHeight/5) + "px";
    newDiv.style.left = (document.body.scrollLeft + document.body.clientWidth/2 - newDivWidth/2) + "px";
    newDiv.style.background = "#FFFFFF";
    newDiv.style.padding = "5px";
    newDiv.innerHTML += '<div style="padding:5px 15px;background-color:#EEEEFE;text-align:left; color: #000000;"><img src="/images/user/icon_rgt_k.gif"> 请您在新打开的支付宝页面上完成付款。</div>';
    newDiv.innerHTML += '<div style="border:1px solid #CCCCEE">';
    newDiv.innerHTML += '<div id="login_content">';
    newDiv.innerHTML += '<div style="margin-top:50px; color: #000000; padding-left:20px; font-size: 16px;"><strong>付款完成前请不要关闭此窗口。</strong></div>';
    newDiv.innerHTML += '</div>';
    newDiv.innerHTML += '</div>';

    document.body.appendChild(newDiv);

    //弹出层滚动居中

    function newDivCenter()
    {
        newDiv.style.top = (document.body.scrollTop + document.body.clientHeight/2 - newDivHeight/2) + "px";
        newDiv.style.left = (document.body.scrollLeft + document.body.clientWidth/2 - newDivWidth/2) + "px";
    }
    if(document.all)
    {
        window.attachEvent("onscroll",newDivCenter);
    }
    else
    {
        window.addEventListener('scroll',newDivCenter,false);
    }

    //关闭新图层和mask遮罩层

    var newA = document.createElement("button");
    newA.className = 'buttonPay';
    newA.innerHTML = '已完成付款，点击关闭';
    newA.onclick = function()
    {
        if(document.all)
        {
            window.detachEvent("onscroll",newDivCenter);
        }
        else
        {
            window.removeEventListener('scroll',newDivCenter,false);
        }
        document.body.removeChild(docEle(_id));
        document.body.removeChild(docEle(m));
        window.location.href = '/pay/result?o=' + _p;
        return false;
    }
    newDiv.appendChild(newA);
}

function vip(){
    var key = document.getElementById("key").innerText;
    if(key=="更大空间"){
        document.getElementById("vip_1").style.display = "";
        document.getElementById("key").innerText="收起";
    }else{
        document.getElementById("vip_1").style.display = "none";
        document.getElementById("key").innerText="更大空间";
    }
}
