// Базовые правила валидации
export default {
  // Обязательное поле
  required: (value, fieldName) => {
    if (value === undefined || value === null || value === '') {
      return { valid: false, message: `${fieldName} обязательно для заполнения` }
    }
    if (typeof value === 'string' && !value.trim()) {
      return { valid: false, message: `${fieldName} обязательно для заполнения` }
    }
    if (typeof value === 'boolean' && value === false) {
      return { valid: false, message: `Необходимо согласие` }
    }
    return null
  },

  // Тип string
  string: (value, fieldName) => {
    if (value && typeof value !== 'string') {
      return { valid: false, message: `${fieldName} должно быть строкой` }
    }
    return null
  },

  // Тип boolean
  bool: (value, fieldName) => {
    if (value !== undefined && typeof value !== 'boolean') {
      return { valid: false, message: `${fieldName} должно быть булевым значением` }
    }
    return null
  },

  // Минимальная длина (ожидается, что min будет вызываться с параметром, но мы его убрали)
  // Если все же нужно, можно добавить, но по условию не требуется.
  // Оставим для справки, но в финальной версии удалим или закомментируем.
  // min: (value, min, fieldName) => { ... },

  // Максимальная длина (аналогично)
  // max: (value, max, fieldName) => { ... },

  // Email
  email: (value, fieldName) => {
    if (!value) return null
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailRegex.test(value)) {
      return { valid: false, message: `${fieldName} должен быть корректным email` }
    }
    return null
  },

  // Логин (буквы, цифры, подчеркивание)
  login: (value, fieldName) => {
    if (!value) return null
    const loginRegex = /^[a-zA-Z0-9_]+$/
    if (!loginRegex.test(value)) {
      return { valid: false, message: `${fieldName} может содержать только буквы, цифры и нижнее подчеркивание` }
    }
    return null
  },

  // Телефон
  phone: (value, fieldName) => {
    if (!value) return null
    const phoneRegex = /^\+?[78][-\(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$/
    if (!phoneRegex.test(value)) {
      return { valid: false, message: `${fieldName} должен быть корректным (например, +71234567890)` }
    }
    return null
  },

  // Пароль (минимум 6 символов, буквы и цифры)
  password: (value, fieldName) => {
    if (!value) return null
    if (value.length < 6) {
      return { valid: false, message: `${fieldName} должен содержать минимум 6 символов` }
    }
    if (!/[A-Za-z]/.test(value) || !/\d/.test(value)) {
      return { valid: false, message: `${fieldName} должен содержать хотя бы одну букву и одну цифру` }
    }
    return null
  },

  // Имя (только латиница)
  name: (value, fieldName) => {
    if (!value) return null
    const nameRegex = /^[a-zA-Z]+$/
    if (!nameRegex.test(value)) {
      return { valid: false, message: `${fieldName} может содержать только латинские буквы` }
    }
    return null
  },

  // Уникальность (заглушка)
  unique: () => {
    console.warn('Уникальность проверяется на сервере')
    return null
  }
}
