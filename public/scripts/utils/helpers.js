function _(selector) {
  return document.querySelector(selector);
}

function formatDate(date) {
  return new Date(date * 1000).toLocaleString().replaceAll("/", "-");
}

export { _, formatDate };
