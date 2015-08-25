String.prototype.trim = function()
{
    return this.replace(/(^[\\s]*)|([\\s]*$)/g, "");
}

function checkform(v1,v2,v3,v4)
{
    var regu = "^[0-9a-zA-Z]+$";
    var re = new RegExp(regu);
    if ((v1 != "" && v1 != null)&&(v2 != "" && v2 != null && re.test(v2))&&(v3 != "" && v3 != null)&&(v4 != "" && v4 != null) )
    {
       if(!/(\S)+[@]{1}(\S)+[.]{1}(\w)+/.test(v1)){
           return false;
       }else if(v3.toString()!=v4.toString()){
           document.getElementById("pwconfirm_empty_msg").style.display = "none";
           document.getElementById("pwconfirm_error_msg").style.display = "";
           document.getElementById("pwconfirm_true_msg").style.display = "none";
           document.getElementById("pwconfirm_info").style.display="none";
         return false;
       }else{
         return true;
       }
    }else{
          alert("带\"*\"必填项不能为空,且用户名必须是英文或数字!");
          return false;
    }
}

        function checkemail()
    {
      var email=document.getElementById("email").value;
            var patrn=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            if (!patrn.exec(email.trim())|| "" == email || null == email){
                document.getElementById("emailinfo").style.display = "none";
                document.getElementById("email_error_msg").style.display = "";
                document.getElementById("email_exist_msg").style.display = "none";
                document.getElementById("email_true_msg").style.display = "none";
            }
           else
           {
                var str = "email="+email;
                $.ajax(
                        {
                            type:'POST',
                            url:'../common/Register_Check.php',
                            data:str,
                            success:function(msg){
                                        if (msg == "0"){
                                            document.getElementById("emailinfo").style.display = "none";
                                            document.getElementById("email_error_msg").style.display = "none";
                                            document.getElementById("email_exist_msg").style.display = "none";
                                            document.getElementById("email_true_msg").style.display = "";
                                        }
                                        if (msg == "1"){
                                          document.getElementById("emailinfo").style.display = "none";
                                          document.getElementById("email_error_msg").style.display = "none";
                                          document.getElementById("email_exist_msg").style.display = "";
                                          document.getElementById("email_true_msg").style.display = "none";
                                        }
                            }
                        }
                );

           }
    }

    function checkuname()
    {
        var regu = "^[0-9a-zA-Z]+$";
        var re = new RegExp(regu);
        if ("" ==  document.getElementById("user").value || null == document.getElementById("user").value || document.getElementById("user").value.length>16)
        {
                document.getElementById("name_info").style.display = "none";
                document.getElementById("name_error_msg").style.display = "";
                document.getElementById("name_true_msg").style.display = "none";
                document.getElementById("name_check").style.display = "none";
                document.getElementById("name_exist").style.display = "none";
        }
        else if(re.test( document.getElementById("user").value )){
                var str = "name="+document.getElementById("user").value;
                $.ajax(
                        {
                            type:'POST',
                            url:'../common/Register_Check.php',
                            data:str,
                            success:function(msg){
                                        if (msg == "0"){
                                            document.getElementById("name_error_msg").style.display = "none";
                                            document.getElementById("name_true_msg").style.display = "";
                                            document.getElementById("name_info").style.display = "none";
                                            document.getElementById("name_check").style.display = "none";
                                            document.getElementById("name_exist").style.display = "none";

                                        }
                                        if (msg == "1"){
                                            document.getElementById("name_error_msg").style.display = "none";
                                            document.getElementById("name_true_msg").style.display = "none";
                                            document.getElementById("name_info").style.display = "none";
                                            document.getElementById("name_check").style.display = "none";
                                            document.getElementById("name_exist").style.display = "";
                                        }
                            }
                        }
                );
        }
        else {
                document.getElementById("name_info").style.display = "none";
                document.getElementById("name_error_msg").style.display = "none";
                document.getElementById("name_true_msg").style.display = "none";
                document.getElementById("name_check").style.display = "";
                document.getElementById("name_exist").style.display = "none";
        }
    }

    function checkpwd()
    {
        if(document.getElementById("pass").value=="" || document.getElementById("pass").value.length<6)
        {
                    document.getElementById("pw_error_msg").style.display = "";
                    document.getElementById("pw_true_msg").style.display = "none";
                    document.getElementById("pw_info").style.display = "none";
        }else{
                   document.getElementById("pw_error_msg").style.display = "none";
                   document.getElementById("pw_true_msg").style.display = "";
                   document.getElementById("pw_info").style.display = "none";
        }
    }

    function checkrepwd()
    {
        if(document.getElementById("confpass").value=="")
        {
               document.getElementById("pwconfirm_empty_msg").style.display = "";
               document.getElementById("pwconfirm_error_msg").style.display = "none";
               document.getElementById("pwconfirm_true_msg").style.display = "none";
               document.getElementById("pwconfirm_info").style.display="none";
        }else if(document.getElementById("confpass").value != document.getElementById("pass").value){
               document.getElementById("pwconfirm_empty_msg").style.display = "none";
               document.getElementById("pwconfirm_error_msg").style.display = "";
               document.getElementById("pwconfirm_true_msg").style.display = "none";
               document.getElementById("pwconfirm_info").style.display="none";
        }else{
               document.getElementById("pwconfirm_empty_msg").style.display = "none";
               document.getElementById("pwconfirm_error_msg").style.display = "none";
               document.getElementById("pwconfirm_true_msg").style.display = "";
               document.getElementById("pwconfirm_info").style.display="none";

        }
    }

    function checkuser_type()
    {
        if(document.getElementById("user_type").value=="2")
        {
                    document.getElementById("user_type_w").style.display = "";
                    document.getElementById("user_type_n").style.display = "none";
        }else{
                    document.getElementById("user_type_w").style.display = "none";
                    document.getElementById("user_type_n").style.display = "";
        }
    }

    function check_couponcode()
    {
        if(document.getElementById("couponcode_2").value != document.getElementById("couponcode_1").value){
               document.getElementById("couponcode_error_msg").style.display = "";
               document.getElementById("couponcode_true_msg").style.display = "none";
        }else{
               document.getElementById("couponcode_error_msg").style.display = "none";
               document.getElementById("couponcode_true_msg").style.display = "";

        }
    }