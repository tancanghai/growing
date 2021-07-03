import request from '@/utils/request'

const api = {
  // plugin: '/plugin',
  user: '/user',
  role: '/role',
  service: '/service',
  permission: '/permission',
  permissionNoPager: '/permission/no-pager',
  orgTree: '/org/tree',
  blacklist: '/riskMan/blacklist',
  challenge: '/riskMan/challenge',
  tester: '/riskMan/tester',
  applist: '/applist',
  alertlist: '/alertlist'
}

export default api

// 获取风控插件列表
// export function getPluginList (parameter) {
//   return request({
//     url: api.plugin,
//     method: 'get',
//     params: parameter
//   })
// }

export function getUserList (parameter) {
  return request({
    url: api.user,
    method: 'get',
    params: parameter
  })
}

// 获取风控名单
export function getBlackList (parameter) {
  return request({
    url: api.blacklist,
    method: 'get',
    params: parameter
  })
}

// 获取回避名单
export function getChallengeList (parameter) {
  return request({
    url: api.challenge,
    method: 'get',
    params: parameter
  })
}

// 获取测试员名单
export function getTesterList (parameter) {
  return request({
    url: api.tester,
    method: 'get',
    params: parameter
  })
}

// 获取风控接入的应用名单
export function getAppList (parameter) {
  return request({
    url: api.applist,
    method: 'get',
    params: parameter
  })
}

export function getAlertList (parameter) {
  return request({
    url: api.alertlist,
    method: 'get',
    params: parameter
  })
}

export function getRoleList (parameter) {
  return request({
    url: api.role,
    method: 'get',
    params: parameter
  })
}

export function getServiceList (parameter) {
  return request({
    url: api.service,
    method: 'get',
    params: parameter
  })
}

export function getPermissions (parameter) {
  return request({
    url: api.permissionNoPager,
    method: 'get',
    params: parameter
  })
}

export function getOrgTree (parameter) {
  return request({
    url: api.orgTree,
    method: 'get',
    params: parameter
  })
}

// id == 0 add     post
// id != 0 update  put
export function saveService (parameter) {
  return request({
    url: api.service,
    method: parameter.id === 0 ? 'post' : 'put',
    data: parameter
  })
}

export function saveSub (sub) {
  return request({
    url: '/sub',
    method: sub.id === 0 ? 'post' : 'put',
    data: sub
  })
}
