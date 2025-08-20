export function getTranslation(key, replacements = {}) {
  let translation = window.translations[key] || key;
  for (const [placeholder, value] of Object.entries(replacements)) {
    translation = translation.replace(`:${placeholder}`, value);
  }
  return translation;
}
