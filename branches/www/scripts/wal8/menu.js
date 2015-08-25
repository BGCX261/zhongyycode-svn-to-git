
// 图片拷贝

function EnhancedImage(src,onLoaded){
    var self = this;
    this.src = src;
    this.width = 0;
    this.height = 0;
    this.onLoaded = onLoaded;
    this.loaded = false;
    this.image = null;

    this.load = function(){
        if(this.loaded)
            return;
        this.image = new Image();
        this.image.src = this.src;
        function loadImage(){
            if(self.width != 0 && self.height != 0){
                clearInterval(interval);
                self.onLoaded(self);//将实例传入回调函数
            }
            self.width = self.image.width;//是number类型
            self.height = self.image.height;
        }
        var interval = window.setInterval(loadImage,100);
    }
}
var img = new EnhancedImage("http://www.google.cn/intl/zh-CN/images/logo_cn.gif",onImageLoad);

function onImageLoad(image){
    var newdiv=document.createElement("div");
        //newdiv.style.display="none";
        var copyImg=newdiv.appendChild(image.image);
        document.body.appendChild(newdiv);

    var ctrl = document.body.createControlRange();
    ctrl.addElement(copyImg);
    ctrl.execCommand('Copy');

        window.alert('复制成功！');
}

function copy_pic(pic) {
    img.src = pic;
    img.load();
}



function   cls(){
//捕获触发事件的对象，并设置为以下语句的默认对象
with(event.srcElement)
      //如果当前值为默认值，则清空
if(value==defaultValue)   value=""
}
function   res(){
//捕获触发事件的对象，并设置为以下语句的默认对象
with(event.srcElement)
//如果当前值为空，则重置为默认值
if(value=="")   value=defaultValue
}

/**过滤表单中的特殊字符*/
function checkSpecialCharacter(inputvalue)
{
    var str = $('#' + inputvalue).val();
    var SPECIAL_STR = "￥#$~!@%^&*();'\"?><[]{}\\|,:/=+—“”‘";
    for(i = 0; i < str.length; i++)
    if (SPECIAL_STR.indexOf(str.charAt(i)) != -1) {
        alert("不能填写非法字符("+str.charAt(i)+")！");
        inputvalue.value = '';
        inputvalue.focus();
        return false;
    }
    return true;
}
