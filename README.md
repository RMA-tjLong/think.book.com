统一返回格式:
    (json){data:数据,status:true/false,msg:提示信息}

管理端接口
    1.登录验证
        请求:
            admin/api/v1/auth/login (post)
        参数:
            username 用户名
            password 密码
        返回:
            JWT token，验证成功后将该token带入请求头请求。
    
    2.用户列表
        请求:
            admin/api/v1/users/list (get)
        参数:
            page     页码（选填，默认为1）
            wd       模糊搜索，范围为 电话/openid/unionid（选填）
            s1       openid精确搜索（选填）
            s2       unionid精确搜索（选填）
            s3       电话精确搜索（选填）
            s4       昵称精确搜索（选填）
            s5       注册时间范围，如2016-02-11_2016-03-12，中间以“_”分隔，空缺起始时间或终止时间如2016-02-11_，不能省略“_”，若不进行时间筛选，则参数值为空
                     如 added_at=&... 或 不上传参数值（选填）
            s6       借阅vip等级精确搜索（选填）[0：非vip；1：月卡；2：季卡；3：年卡]
            s7       借阅余额范围，如10.00_20.23，不能省略“_”，同上（选填）
            s8       借阅到期时间范围（选填）
            s9       课程vip等级精确搜索（选填）[0：非vip；1：vip]
            s10      课程vip余额范围（选填）
        返回:
            查询结果（包括 数据、总数、当前页数、总页数）
    
    3.用户借阅vip等级更新
        请求:
            admin/api/v1/users/change-book-vip (post)
        参数:
            id  用户id
            vip vip等级（0：非vip，1：月卡vip，2：季卡vip，3：年卡vip）
        返回:
            修改结果
    
    4.用户借阅vip到期时间更新
        请求:
            admin/api/v1/users/change-book-vip-ended (post)
        参数:
            id       用户id
            ended_at 到期时间（日期），如 2013-05-02
        返回:
            修改结果

    5.用户课程vip等级更新
        请求:
            admin/api/v1/users/change-class-vip (post)
        参数:
            id  用户id
            vip vip等级（0：非vip，1：vip）
        返回:
            修改结果
        
    6.用户教师标签
        请求:
            admin/api/v1/users/set-teacher (post)
        参数:
            id        用户id
            i_teacher 设置/取消教师标签（1：设置教师标签，0：取消教师标签）
        返回:
            修改结果

    7.用户信息查询
        请求:
            admin/api/v1/users/info (get)
        参数:
            id 用户id
        返回:
            查询结果

    8.更改借阅余额
        请求:
            admin/api/v1/users/change-book-balance (post)
        参数:
            id      用户id
            balance 余额（保留两位小数），如 20.52
        返回:
            修改结果

    9.更改课时余额
        请求:
            admin/api/v1/users/change-class-balance (post)
        参数:
            id      用户id
            balance 余额（整数）
        返回:
            修改结果
