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
            openid   openid精确搜索（选填）
            unionid  unionid精确搜索（选填）
            nickname 昵称精确搜索（选填）
            phone    电话精确搜索（选填）
            added_at 注册时间范围，如2016-02-11_2016-03-12，中间以“_”分隔，空缺起始时间或终止时间如2016-02-11_，不能省略“_”，若不进行时间筛选，则参数值为空
                     如 added_at=&... 或 不上传参数值（选填）
            vip      vip等级精确搜索（选填）
            balance  余额范围，如10.00_20.23，不能省略“_”，同上（选填）
        返回:
            查询结果（包括 数据、总数、当前页数、总页数）
    
    3.用户vip更新
        请求:
            admin/api/v1/users/change-vip (post)
        参数:
            id  用户id
            vip vip等级
        返回:
            修改结果

    4.用户余额添加
        请求:
            admin/api/v1/users/add-balance (post)
        参数:
            id          用户id
            add_balance 需要添加到余额的金钱数目
        返回:
            修改结果

    5.用户信息查询
        请求:
            admin/api/v1/users/info (get)
        参数:
            id 用户id
        返回:
            查询结果