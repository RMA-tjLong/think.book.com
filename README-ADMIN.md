
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
wd       模糊搜索，范围为 电话（选填）  
s1       电话精确搜索（选填）  
s2       昵称精确搜索（选填）  
s3       注册时间范围，如2016-02-11_2016-03-12，中间以“_”分隔，空缺起始时间或终止时间如2016-02-11_，不能省略“_”，若不进行时间筛选，则参数值为空，如 added_at=&... 或 不上传参数值（选填）  
s4       借阅vip等级精确搜索（选填）[0：非vip；1：月卡；2：季卡；3：年卡]  
s5       借阅余额范围，如10.00_20.23，不能省略“_”，同上（选填）  
s6       借阅到期时间范围（选填）  
s7       课程vip等级精确搜索（选填）[0：非vip；1：vip]  
s8       课程vip余额范围（选填）

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
### 上传excel[该方法不必要上传jwt token]
>**请求:**
admin/api/v1/uploads/excel (post)

>**参数:**  
excel 大小限制100M，文件后缀须为mp4，不支持批量上传

>**返回:**
对象，包括文件名与文件url访问地址（/static/uploads/excel/....xlsx）
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
s4 课程分类搜索（课程分类列表由课程分类接口获得）  

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
catid 课程分类id（必填，由课程分类接口获取）

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
catid 课程分类id  

>**返回:**
修改结果
***
### 企业信息详情
>**请求:**
admin/api/v1/info/info (get)  

>**参数:** 无

>**返回:**
查询结果
***
### 企业信息更新
>**请求:** 
admin/api/v1/info/change (post)  

>**参数:**    
name 企业名称（必填）  
lat  纬度（必填）  
lng  经度（必填）  
address 公司地址（必填）  
phone  联系电话（必填）  
company_culture 企业文化（选填 text）  
curriculum_structure 课程体系（选填 text）

>**返回:**
修改结果
***
### 活动列表
>**请求:**
admin/api/v1/activities/list (get)

>**参数:**  
page 页码（选填，默认为1）  
kind 分类（选填，默认为1：精品活动；2：商业活动）  
wd 活动标题模糊搜索  
s1 活动标题搜索  
s2 活动状态搜索  
s3 活动添加时间搜索  

>**返回:**
查询结果（包括 数据、分页html代码块）
***
### 活动详情
>**请求:**
admin/api/v1/activities/info (get)

>**参数:**  
id 活动id

>**返回:**
查询结果
***
### 活动删除
>**请求:**
admin/api/v1/activities/drop (post)

>**参数:**  
ids/ids[] 活动id（可以以数组形式上传，则为多项删除）

>**返回:**
删除结果（删除的同时将尝试删除文件）
***
### 活动移除[可通过status = 0查看已删除视频]
>**请求:**
admin/api/v1/activities/delete (post)

>**参数:**  
ids/ids[] 活动id（可以以数组形式上传，则为多项删除）

>**返回:**
移除结果
***
### 活动添加
>**请求:**
admin/api/v1/activities/store (post)

>**参数:**    
title 活动标题（必填）  
kind 分类（选填）  
content 活动内容（选填）  
url 活动链接（必填，如 /static/uploads/activities/....png）   
status 活动状态（in:1,2）

>**返回:**
添加结果
***
### 活动更新
>**请求:** 
admin/api/v1/activities/change (post)

>**参数:**    
id 活动id（必填）  
title 活动名称（必填）  
content 活动内容（选填）  
kind 活动分类（选填）  
url 活动链接（选填）   
status 活动状态（必填）

>**返回:**
修改结果
***
### 检查用户名是否存在
>**请求:**
admin/api/v1/admins/check-username (post)

>**参数:**
username 用户名（必填）   

>**返回:**
检查结果
***
### 管理员添加
>**请求:**
admin/api/v1/admins/store (post)

>**参数:**    
username 用户名（必填）  
password 密码（必填）  

>**返回:**
添加结果
***
### 下载书单模板
>**请求:**
static/files/books.xlsx (get)  

>**参数:**    

>**返回:** 
***
### 书单上传  
>**请求:**
admin/api/v1/books/import

>**参数:**    
task_name 本次上传名称(非必填，不填则默认名称为当前上传时间)  
excel excel文件路径（由excel上传接口获取）

>**返回:** 
上传结果
***
### 书单列表
>**请求:**
admin/api/v1/books/list (get)

>**参数:**  
page 页码（选填，默认为1）  
wd 书单名称模糊搜索  
s1 书单名称搜索  
s2 书单年龄段搜索（上传年龄段id，年龄段列表由年龄段接口提供）  
s3 书单条码搜索  
s4 书单上传批次搜索（上传批次id，上传批次列表由批次接口提供）  

>**返回:**
查询结果（包括 数据、分页html代码块）
***
### 书单删除
>**请求:**
admin/api/v1/books/drop (post)

>**参数:**  
ids/ids[] 书单id（可通过数组批量删除）  

>**返回:**
删除结果
***
### 书单软删除
>**请求:**
admin/api/v1/books/delete (post)

>**参数:**  
ids/ids[] 书单id（可通过数组批量删除）  

>**返回:**
删除结果
***
### 书单添加
>**请求:**
admin/api/v1/books/store (post)

>**参数:**  
name 书单名，必填  
number 书单编号 必填  
barcode 书单条码 必填  
status 书单状态（上架/下架） 只能为1或2  
num 书单数量 选填 默认为1  
isbn ISBN码 选填  
author 选填  
publishing 出版社 选填  
cover 选填，若不上传则默认为默认封面  
price 总值 选填  
description 描述，出版之类的，富文本，选填   
content 内容简介，富文本 选填   
collection  馆藏 选  
room 书室 选  
shelf 书架 选  
generationid 年龄段id，年龄段获取见年龄段接口，选填  

>**返回:**
添加结果
***
### 书单编辑
>**请求:**
admin/api/v1/books/change (post)

>**参数:**  
id 书单id 必填  
name 书单名，必填  
number 书单编号 必填  
barcode 书单条码 必填  
status 书单状态（上架/下架） 必填，只能为1或2，当原来为1（未上架）改为2（上架）时系统自动更新上架时间  
num 书单数量 选填 默认为1  
isbn ISBN码 选填  
author 选填  
publishing 出版社 选填  
cover 必填    
price 总值 选填  
description 描述，出版之类的，富文本，选填   
content 内容简介，富文本 选填   
collection  馆藏 选  
room 书室 选  
shelf 书架 选  
generationid 年龄段id，年龄段获取见年龄段接口，选填  

>**返回:**
添加结果
***
### 书单全部上架
>**请求:**
admin/api/v1/books/upload-all (post)

>**参数:**  

>**返回:**
上架结果
***
### 书单批量上架
>**请求:**
admin/api/v1/books/upload-batch (post)

>**参数:**  
ids/ids[]  

>**返回:**
上架结果
***
### 书单批量更新年龄段
>**请求:**
admin/api/v1/books/change-generation-batch (post)

>**参数:**  
ids/ids[]  
generationid 年龄段id，由年龄段接口获得  

>**返回:**
更新结果
***
### 年龄段列表
>**请求:**
admin/api/v1/generations/list (get)

>**参数:**  
无分页，直接获取全部，方便书单页面上修改年龄段select使用

>**返回:**
查询结果
***
### 年龄段添加
>**请求:**
admin/api/v1/generations/store (post)

>**参数:**  
name 年龄段名称 必填  

>**返回:**
查询结果
***
### 年龄段编辑
>**请求:**
admin/api/v1/generations/change (post)

>**参数:**  
id 年龄段id 必填  
name 年龄段名称 必填  

>**返回:**
查询结果
***
### 年龄段删除
>**请求:**
admin/api/v1/generations/drop (post)

>**参数:**  
ids/ids[] 年龄段id 必填  

>**返回:**
查询结果
***
### 课程分类列表
>**请求:**
admin/api/v1/course-categories/list (get)

>**参数:**  
无分页，直接获取全部

>**返回:**
查询结果
***
### 课程分类添加
>**请求:**
admin/api/v1/course-categories/store (post)

>**参数:**  
name 分类名称 必填  

>**返回:**
查询结果
***
### 课程分类编辑
>**请求:**
admin/api/v1/course-categories/change (post)

>**参数:**  
id 分类id 必填  
name 分类名称 必填  

>**返回:**
查询结果
***
### 课程分类删除
>**请求:**
admin/api/v1/course-categories/drop (post)

>**参数:**  
ids/ids[] 分类id 必填  

>**返回:**
查询结果
***
### 上传批次列表
>**请求:**
admin/api/v1/tasks/list (get)

>**参数:**  
wd 模糊查询批次名称  
s1 精确查询批次名称  
s2 查询上传时间范围  

>**返回:**
查询结果
***
### 上传批次编辑
>**请求:**
admin/api/v1/tasks/change (post)

>**参数:**  
id 上传批次id 必填  
name 上传批次名称 必填  

>**返回:**
查询结果
***
### 上传批次删除（删除上传批次将删除该上传批次的所有书单）
>**请求:**
admin/api/v1/tasks/drop (post)

>**参数:**  
ids/ids[] 上传批次id 必填  

>**返回:**
查询结果

