import { reactive, watch } from 'vue'
import rules from './rules'

/**
 * Хук для валидации формы
 * @param {Object} form - реактивный объект с полями формы
 * @param {Object} validationRules - правила для полей: { fieldName: Array<string|Function> }
 * @param {Object} labels - опциональные названия полей для сообщений (по умолчанию ключи поля)
 * @returns {Object} - состояние и методы валидации
 */
export function useFormValidation(form, validationRules = {}, labels = {}) {
  // Создаём реактивное состояние для каждого поля формы
  const validation = reactive({})

  // Инициализация
  for (const fieldName of Object.keys(form)) {
    validation[fieldName] = {
      value: form[fieldName],
      valid: true,
      message: '',
      rules: [] // будет заполнено позже
    }
  }

  // Функция компиляции правил для поля
  function compileFieldRules(fieldName, ruleConfig) {
    const fieldRules = []
    const fieldLabel = labels[fieldName] || fieldName

    if (!ruleConfig || !Array.isArray(ruleConfig)) {
      return fieldRules // нет правил
    }

    for (const ruleItem of ruleConfig) {
      if (typeof ruleItem === 'function') {
        // Если правило - функция, оборачиваем, чтобы передать label и форму
        fieldRules.push((value, form) => ruleItem(value, form, fieldLabel))
      } else if (typeof ruleItem === 'string') {
        // Если строка - ищем правило в объекте rules
        const ruleFn = rules[ruleItem]
        if (ruleFn) {
          // Правило из rules ожидает (value, fieldName)
          fieldRules.push((value) => ruleFn(value, fieldLabel))
        } else {
          console.warn(`Правило "${ruleItem}" не найдено в списке доступных правил`)
        }
      }
    }
    return fieldRules
  }

  // Заполняем rules для каждого поля
  for (const fieldName of Object.keys(validation)) {
    const ruleConfig = validationRules[fieldName]
    validation[fieldName].rules = compileFieldRules(fieldName, ruleConfig)
  }

  // Валидация конкретного поля
  const validateField = (fieldName) => {
    const field = validation[fieldName]
    if (!field) return true

    const value = form[fieldName]
    field.value = value

    if (!field.rules || field.rules.length === 0) {
      field.valid = true
      field.message = ''
      return true
    }

    for (const rule of field.rules) {
      const result = rule(value, form) // передаём и значение, и всю форму (для функций)
      if (result) {
        field.valid = result.valid
        field.message = result.message
        return false
      }
    }

    field.valid = true
    field.message = ''
    return true
  }

  // Валидация всех полей
  const validateAll = () => {
    let isValid = true
    for (const fieldName of Object.keys(validation)) {
      const fieldValid = validateField(fieldName)
      if (!fieldValid) isValid = false
    }
    return isValid
  }

  // Сброс валидации
  const resetValidation = (fieldName = null) => {
    if (fieldName && validation[fieldName]) {
      validation[fieldName].valid = true
      validation[fieldName].message = ''
    } else {
      for (const key in validation) {
        validation[key].valid = true
        validation[key].message = ''
      }
    }
  }

  // Следим за изменениями формы и обновляем значения в validation
  watch(form, (newForm) => {
    for (const key in newForm) {
      if (validation[key]) {
        validation[key].value = newForm[key]
      }
    }
  }, { deep: true })

  return {
    validation,
    validateField,
    validateAll,
    resetValidation
  }
}
