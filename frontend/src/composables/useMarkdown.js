import MarkdownIt from 'markdown-it'

// Configure markdown-it with options
const md = new MarkdownIt({
  html: true,         // Enable HTML tags in source
  linkify: true,      // Autoconvert URL-like text to links
  typographer: true,  // Enable some language-neutral replacement + quotes beautification
  breaks: true        // Convert '\n' in paragraphs into <br>
})

export function useMarkdown() {
  const renderMarkdown = (source) => {
    if (!source) return ''
    return md.render(source)
  }

  return {
    renderMarkdown
  }
}