
> 统一返回格式: (json) {data:数据, status:true/false, msg:提示信息}

## 管理端接口
### 登录验证
>**请求:**
api/v1/auth/login (post)

>**参数:**  
phone 用户电话号码  
password 密码  
nickname 小程序自带获取用户信息-昵称  
avatar_url 小程序自带获取用户信息-头像  
gender 小程序自带获取用户信息-性别

>**返回:**
用户信息及signature、signature_time，将signature、signature_time存入header，在需要用到用户信息的操作时提交该参数  
***
### 用户电话号码查重
>**请求:**
api/v1/auth/check-phone (post)

>**参数:**  
phone  用户注册所使用的电话号码  

>**返回:**
查询结果
***
### 用户注册
>**请求:**
api/v1/auth/register (post)

>**参数:**  
phone    电话号码（正则验证一下吧..）  
password 密码  

>**返回:**
注册结果
***
