/**
 * Created by wuhan on 2018/3/12.
 */

Number.prototype.zb = function() {
    var value = this;
    return {
        // 加法
        add: function (arg) {
            var r1, r2, m;
            try { r1 = value.toString().split(".")[1].length; } catch (e) { r1 = 0; }
            try { r2 = arg.toString().split(".")[1].length; } catch (e) { r2 = 0; }
            m = Math.pow(10, Math.max(r1, r2));
            return (value * m + arg * m) / m;
        },
        // 减法 
        sub: function (arg) {
            return value.zb().add(-arg);
        },
        // 乘法 
        mul: function (arg) {
            var m = 0, s1 = value.toString(), s2 = arg.toString();
            try { m += s1.split(".")[1].length; } catch (e) { }
            try { m += s2.split(".")[1].length; } catch (e) { }
            return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
        },
        // 除法
        div: function (arg) {
            var t1 = 0, t2 = 0, r1, r2;
            try { t1 = value.toString().split(".")[1].length; } catch (e) { }
            try { t2 = arg.toString().split(".")[1].length; } catch (e) { }
            with (Math) {
                r1 = Number(value.toString().replace(".", ""));
                r2 = Number(arg.toString().replace(".", ""));
                return (r1 / r2) * pow(10, t2 - t1);
            }
        },
        // 保留小数点精度
        toFixed: function (precision) {
            var val = value.toString(), power = Math.pow(10, precision || 0);
            return Number.prototype.toFixed.call((Math.round(val * power) / power), precision);
        }
    };
};

String.prototype.zb = function () {
    var value = this;
    return {
        // 去除左右空格
        trim: function () {
            return value.replace(/(^\s*)|(\s*$)/g, "");
        },
        // 去除左空格 
        ltrim: function () {
            return value.replace(/(^\s*)/g, "");
        },
        // 去除右空格
        rtrim: function () {
            return value.replace(/(\s*$)/g, "");
        },
        // 后面字符串匹配 
        endWith: function (str, isIgnoreCase) {
            if (!str || str.length > value.length)
                return false;
            if (isIgnoreCase) {
                return value.substring(value.length - str.length).toLowerCase() == str.toLowerCase();
            } else {
                return value.substring(value.length - str.length) == str;
            }
        },
        // 前面字符串匹配
        startWith: function (str, isIgnoreCase) {
            if (!str || str.length > value.length)
                return false;
            if (isIgnoreCase) {
                return value.substr(0, str.length).toLowerCase() == str.toLowerCase();
            } else {
                return value.substr(0, str.length) == str;
            }
        },
        // 返回字符串的实际长度, 一个汉字算2个长度   
        strLen: function () {
            return value.replace(/[^\x00-\xff]/g, "**").length;
        },
        //字符串超出省略 
        cutStr: function (len) {
            var restr = value;
            var wlength = value.replace(/[^\x00-\xff]/g, "**").length;
            if (wlength > len) {
                for (var k = len / 2; k < value.length; k++) {
                    if (value.substr(0, k).replace(/[^\x00-\xff]/g, "**").length >= len) {
                        restr = value.substr(0, k) + "...";
                        break;
                    }
                }
            }
            return restr;
        }
    }
};

Array.prototype.zb = function () {
    var value = this;
    return {
        // 元素在数组中的位置
        indexOf: function (v) {
            for (var i = 0; i < value.length; i++) {
                if (value[i] == v) {
                    return i;

                }
            }
            return -1;
        },
        // 移除元素
        remove: function (v) {
            var i = value.zb().indexOf(v);
            if (i > -1) {
                value.splice(i, 1);
            }
            return [i, v];
        }
    };
};


//验证是否为金额格式，只精确两位小数。
function isMoney(str) {
    if (str == "" || str == null) {
        return true;
    }
    return /^[+]?\d*\.{0,1}\d{0,2}$/.test(str);
}

//获取URL中的request参数
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
    { return decodeURIComponent(r[2]); }
    else
    { return ""; }
}



