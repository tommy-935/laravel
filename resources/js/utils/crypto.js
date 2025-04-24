// src/utils/crypto.js
import CryptoJS from 'crypto-js'

class CryptoUtil {
  /**
   * 生成随机密钥
   * @param {number} length 密钥长度(默认32)
   * @returns {string} 随机密钥
   */
  static generateKey(length = 32) {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
    let key = ''
    for (let i = 0; i < length; i++) {
      key += chars.charAt(Math.floor(Math.random() * chars.length))
    }
    return key
  }

  /**
   * 加密数据
   * @param {string} data 要加密的数据
   * @param {string} key 加密密钥
   * @returns {string} 加密后的字符串
   */
  static encrypt(data, key) {
    return CryptoJS.AES.encrypt(data, key).toString()
  }

  /**
   * 解密数据
   * @param {string} encrypted 加密后的字符串
   * @param {string} key 加密密钥
   * @returns {string} 解密后的原始数据
   */
  static decrypt(encrypted, key) {
    const bytes = CryptoJS.AES.decrypt(encrypted, key)
    return bytes.toString(CryptoJS.enc.Utf8)
  }
}

export default CryptoUtil