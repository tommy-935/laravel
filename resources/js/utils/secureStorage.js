// src/utils/secureStorage.js
import CryptoUtil from './crypto'

class SecureStorage {
  /**
   * 构造函数
   * @param {string} [namespace] 命名空间
   * @param {string} [encryptionKey] 加密密钥(不传则使用默认密钥)
   */
  constructor(namespace = '', encryptionKey = null) {
    this.namespace = namespace ? `${namespace}:` : ''
    this.encryptionKey = encryptionKey || this._getDefaultKey()
  }

  /**
   * 获取默认加密密钥
   * @returns {string} 默认密钥
   * @private
   */
  _getDefaultKey() {
    // 可以从环境变量获取或使用固定值(生产环境建议从服务器获取)
    return process.env.VUE_APP_STORAGE_SECRET || 'default-secret-key-12345'
  }

  /**
   * 获取完整存储键名
   * @param {string} key 键名
   * @returns {string} 完整键名
   * @private
   */
  _getFullKey(key) {
    return `${this.namespace}${key}`
  }

  /**
   * 设置加密存储项
   * @param {string} key 键名
   * @param {*} value 值
   * @param {number} [expire] 过期时间(秒)
   */
  set(key, value, expire) {
    const storageData = {
      value,
      expire: expire ? Date.now() + expire * 1000 : null
    }
    
    const encrypted = CryptoUtil.encrypt(
      JSON.stringify(storageData), 
      this.encryptionKey
    )
    
    localStorage.setItem(this._getFullKey(key), encrypted)
  }

  /**
   * 获取解密后的存储项
   * @param {string} key 键名
   * @returns {*} 存储的值或null(如果不存在/已过期/解密失败)
   */
  get(key) {
    const encrypted = localStorage.getItem(this._getFullKey(key))
    if (!encrypted) return null

    try {
      const decrypted = CryptoUtil.decrypt(encrypted, this.encryptionKey)
      const data = JSON.parse(decrypted)
      
      // 检查是否过期
      if (data.expire && Date.now() > data.expire) {
        this.remove(key)
        return null
      }
      
      return data.value
    } catch (error) {
      console.error('解密失败:', error)
      return null
    }
  }

  /**
   * 移除存储项
   * @param {string} key 键名
   */
  remove(key) {
    localStorage.removeItem(this._getFullKey(key))
  }

  /**
   * 清空当前命名空间下的所有存储项
   */
  clear() {
    const prefix = this.namespace
    Object.keys(localStorage)
      .filter(key => key.startsWith(prefix))
      .forEach(key => localStorage.removeItem(key))
  }

  /**
   * 检查存储项是否存在
   * @param {string} key 键名
   * @returns {boolean}
   */
  has(key) {
    return this.get(key) !== null
  }

  /**
   * 获取所有存储键名(不包含命名空间前缀)
   * @returns {string[]}
   */
  keys() {
    const prefix = this.namespace
    return Object.keys(localStorage)
      .filter(key => key.startsWith(prefix))
      .map(key => key.slice(prefix.length))
  }
}

export default SecureStorage