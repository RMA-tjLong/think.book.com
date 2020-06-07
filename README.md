
> 统一返回格式: (json) {data:数据, status:true/false, msg:提示信息}

## 管理端接口
### 登录验证
>**请求:**
admin/api/v1/auth/login (post)

>**参数:**  
username 用户名  
password 密码

>**返回:**
JWT token，验证成功后将该token带入请求头请求。
***
### 用户列表
>**请求:**
admin/api/v1/users/list (get)

>**参数:**  
page     页码（选填，默认为1）  
wd       模糊搜索，范围为 电话/openid/unionid（选填）  
s1       openid精确搜索（选填）  
s2       unionid精确搜索（选填）  
s3       电话精确搜索（选填）  
s4       昵称精确搜索（选填）  
s5       注册时间范围，如2016-02-11_2016-03-12，中间以“_”分隔，空缺起始时间或终止时间如2016-02-11_，不能省略“_”，若不进行时间筛选，则参数值为空，如 added_at=&... 或 不上传参数值（选填）  
s6       借阅vip等级精确搜索（选填）[0：非vip；1：月卡；2：季卡；3：年卡]  
s7       借阅余额范围，如10.00_20.23，不能省略“_”，同上（选填）  
s8       借阅到期时间范围（选填）  
s9       课程vip等级精确搜索（选填）[0：非vip；1：vip]  
s10      课程vip余额范围（选填）

>**返回:**
查询结果（包括 数据、分页html代码块）
***
### 用户借阅vip相关更新
>**请求:**
admin/api/v1/users/change-book-vip (post)

>**参数:**  
id       用户id  
vip      vip等级（0：非vip，1：月卡vip，2：季卡vip，3：年卡vip）  
balance  余额（保留两位小数），如 20.52  
ended_at 到期时间（日期），如 2013-05-02  

>**返回:**
修改结果
***
### 用户课程vip相关更新
>**请求:**
admin/api/v1/users/change-class-vip (post)

>**参数:**  
id      用户id  
vip     vip等级（0：非vip，1：vip）  
balance 余额（整数）

>**返回:**
修改结果
***
### 用户教师标签更新
>**请求:**
admin/api/v1/users/change-teacher (post)

>**参数:**  
id        用户id  
i_teacher 设置/取消教师标签（1：设置教师标签，0：取消教师标签）

>**返回:**
修改结果
***
### 用户信息查询
>**请求:**
admin/api/v1/users/info (get)

>**参数:**  
id 用户id

>**返回:**
查询结果
***
### 广告列表
>**请求:**
admin/api/v1/ads/list (get)

>**参数:**  
page 页码（选填，默认为1）

>**返回:**
查询结果（包括 数据、分页html代码块）
***
### 广告详情
>**请求:**
admin/api/v1/ads/info (get)

>**参数:**  
id 广告id

>**返回:**
查询结果
***
### 广告删除
>**请求:**
admin/api/v1/ads/drop (post)

>**参数:**  
ids/ids[] 广告id（可以以数组形式上传，则为多项删除）

>**返回:**
删除结果（删除的同时将尝试删除文件）
***
### 广告添加
>**请求:**
admin/api/v1/ads/store (post)

>**参数:**  
name    广告名称（选填）  
content 广告内容（选填）  
url     广告图片链接（必填，如 /static/uploads/image/....png） 

>**返回:**
添加结果
***
### 广告更新
>**请求:**
admin/api/v1/ads/change (post)

>**参数:**  
id      广告id（必填）  
name    广告名称（选填）  
content 广告内容（选填）  
url     广告图片链接（必填）

>**返回:**
修改结果
***
### 上传图片[该方法不必要上传jwt token]
>**请求:**
admin/api/v1/uploads/image (post)

>**参数:**  
images[] 大小限制2M，文件后缀须为jpg,jpeg,png,gif，支持批量上传

>**返回:**
数组，每个元素包括文件名与文件url访问地址（/static/uploads/image/....png）
***
### 上传视频[该方法不必要上传jwt token]
>**请求:**
admin/api/v1/uploads/video (post)

>**参数:**  
video 大小限制100M，文件后缀须为mp4，不支持批量上传

>**返回:**
对象，包括文件名与文件url访问地址（/static/uploads/video/....png）
***
### 小视频列表
>**请求:**
admin/api/v1/videos/list (get)

>**参数:**  
page 页码（选填，默认为1）  
wd 视频标题模糊搜索  
s1 视频标题搜索  
s2 视频状态搜索  
s3 视频添加时间搜索  

>**返回:**
查询结果（包括 数据、分页html代码块）
***
### 小视频详情
>**请求:**
admin/api/v1/videos/info (get)

>**参数:**  
id 小视频id

>**返回:**
查询结果
***
### 小视频删除
>**请求:**
admin/api/v1/videos/drop (post)

>**参数:**  
ids/ids[] 小视频id（可以以数组形式上传，则为多项删除）

>**返回:**
删除结果（删除的同时将尝试删除文件）
***
### 小视频移除[可通过status = 0查看已删除视频]
>**请求:**
admin/api/v1/videos/delete (post)

>**参数:**  
ids/ids[] 小视频id（可以以数组形式上传，则为多项删除）

>**返回:**
移除结果
***
### 小视频添加
>**请求:**
admin/api/v1/videos/store (post)

>**参数:**    
name 小视频名称（选填）  
content 小视频内容（选填）  
url 小视频链接（必填，如 /static/uploads/videos/....png）

>**返回:**
添加结果
***
### 小视频更新
>**请求:** 
admin/api/v1/videos/change (post)

>**参数:**    
id 小视频id（必填）  
name 小视频名称（选填）  
content 小视频内容（选填）  
url 小视频链接（必填） 
status 小视频状态（必填）

>**返回:**
修改结果
***
### 试听课 / 正式课列表   
>**请求:**   
admin/api/v1/trial-courses/list (get)  
admin/api/v1/formal-courses/list (get)

>**参数:**   
page 页码（选填，默认为1）  
wd 标题模糊搜索  
s1 标题搜索  
s2 状态搜索  
s3 添加时间搜索  

>**返回:**
查询结果
***
### 试听课 / 正式课详情
>**请求:**  
admin/api/v1/trial-courses/info (get)  
admin/api/v1/formal-courses/info (get)

>**参数:**  
id 课程id

>**返回:**
查询结果
***
### 试听课 / 正式课删除
>**请求:**  
admin/api/v1/trial-courses/drop (post)  
admin/api/v1/formal-courses/drop (post)

>**参数:**  
ids/ids[] 课程id（可以以数组形式上传，则为多项删除）

>**返回:**
删除结果
***
### 试听课 / 正式课移除[可通过status = 0查看已删除课程]
>**请求:**  
admin/api/v1/trial-courses/delete (post)  
admin/api/v1/formal-courses/delete (post)

>**参数:**  
ids/ids[] 课程id（可以以数组形式上传，则为多项删除）

>**返回:**
移除结果
***
### 试听课 / 正式课添加
>**请求:**  
admin/api/v1/trial-courses/store (post)  
admin/api/v1/formal-courses/store (post)  

>**参数:**    
name 课程名称（必填）  
content 课程内容（选填）  

>**返回:**
添加结果
***
### 试听课 / 正式课更新
>**请求:**   
admin/api/v1/trial-courses/change (post)  
admin/api/v1/formal-courses/change (post)

>**参数:**    
id 课程id（必填）  
name 课程名称（必填）  
content 课程内容（选填）  
status 课程状态（必填） 

>**返回:**
修改结果

