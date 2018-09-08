
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./mdui');

require('./edit.topic');

window.Vue = require('vue');

let http = {};
// let _baseURL = '/vpaas'
let _baseURL = '/upload_image';
let ContentType = "application/json";

let uploadFileType = "multipart/form-data";
http.baseURL = _baseURL;


/**
 * 上传文件的请求
 * @param url
 * @returns {AxiosPromise}
 */
http.uploadFile = function (url, data) {
  let config = {
    //请求的接口，在请求的时候，如axios.get(url,config);这里的url会覆盖掉config中的url
    url: url,
    //基础url前缀
    baseURL: _baseURL,
    transformResponse: [function (data1) {
      var data = data1;
      if (typeof data1 == "string") {
        data = JSON.parse(data1);
      }
      return data;
    }],
    //请求头信息
    headers: {'Content-Type': uploadFileType},

    //跨域请求时是否需要使用凭证
    withCredentials: true,
    // 返回数据类型
    responseType: 'json', //default
  };
  return axios.post(url, data, config);
};

