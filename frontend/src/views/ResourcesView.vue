<template>
  <div class="resources-page min-h-screen">
    <h2 class="section-title">&lt;Resources/&gt;</h2>
    <section class="resources">
      <div class="resources-cont">
        <!-- Loading State -->
        <div v-if="loading" class="space-y-4">
          <div v-for="n in 3" :key="n" class="resource animate-pulse">
            <div class="h-6 bg-gray-400 rounded mb-4"></div>
            <div class="space-y-2">
              <div class="h-4 bg-gray-500 rounded"></div>
              <div class="h-4 bg-gray-500 rounded w-3/4"></div>
              <div class="h-4 bg-gray-500 rounded w-1/2"></div>
            </div>
          </div>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="resource">
          <h3>Error Loading Resources</h3>
          <div>
            <p>Failed to load resources: {{ error }}</p>
            <button 
              @click="retryLoad" 
              class="bg-blue-600 text-white px-4 py-2 rounded mt-2 hover:bg-blue-700 transition-colors"
            >
              Retry
            </button>
          </div>
        </div>

        <!-- Resources -->
        <div
          v-else
          v-for="resource in resources"
          :key="resource.id"
          :id="resource.id"
          class="resource"
        >
          <h3>{{ resource.title }}</h3>
          <div v-html="renderedContent(resource.content)"></div>
        </div>

        <!-- Empty State -->
        <div v-if="!loading && !error && !resources?.length" class="resource">
          <h3>No Resources Available</h3>
          <div>
            <p>No resources have been published yet. Check back later!</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useResources } from '@/composables/useStrapi'
import { useMarkdown } from '@/composables/useMarkdown'

const { resources, loading, error, loadResources } = useResources()
const { renderMarkdown } = useMarkdown()

const renderedContent = (content) => {
  if (!content) return ''
  return renderMarkdown(content)
}

const retryLoad = async () => {
  try {
    await loadResources({
      populate: '*',
      sort: 'createdAt:desc'
    })
  } catch (err) {
    console.error('Failed to reload resources:', err)
  }
}

onMounted(async () => {
  try {
    await loadResources({
      populate: '*',
      sort: 'createdAt:desc'
    })
  } catch (err) {
    console.error('Failed to load resources:', err)
  }
})
</script>

<style scoped>
/*Designed and Developed by Aiden Johnson | TGM.One*/
h2.section-title {
  text-align: center;
  color: #8594C0;
  font-size: 2.5em;
  font-weight: 700;
  letter-spacing: 2px;
  margin-bottom: 1.5em;
  margin-top: 1em;
}

.resources-cont {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 1rem;
}

@media (max-width: 768px) {
  .resources-cont {
    padding: 0 1.5rem;
  }
}

@media (max-width: 480px) {
  .resources-cont {
    padding: 0 1rem;
  }
}

.resource {
  background-color: rgba(0, 0, 0, 0.53);
  border: 5px solid;
  border-image-slice: 1;
  border-width: 5px;
  border-image-source: linear-gradient(to right, #007BFF, #0065D1, #007BFF);
  padding: 10px;
  margin-bottom: 1em;
}

.resource h3 {
  border-bottom: 5px solid;
  border-color: #007BFF;
  margin: 0 -10px;
  padding: 0 10px;
  padding-bottom: 10px;
  color: #9AA5CB;
  font-size: 1.5rem;
  font-weight: 600;
}

.resource div {
  color: #9AA5CB;
  padding: 5px 5px 0 5px;
}

.resource :deep(a) {
  color: #2E93FF;
  text-decoration: underline;
}

.resource :deep(a:hover) {
  color: #007BFF;
  transition: color 0.2s;
}

.resource :deep(ul) {
  padding-left: 20px;
}

.resource :deep(ol) {
  padding-left: 20px;
}

.resource :deep(p) {
  margin-bottom: 0.5em;
  line-height: 1.6;
}

.resource :deep(code) {
  background-color: rgba(255, 255, 255, 0.1);
  padding: 2px 6px;
  border-radius: 3px;
  font-family: 'Courier New', monospace;
  color: #E6E6E6;
}

.resource :deep(pre) {
  background-color: rgba(0, 0, 0, 0.7);
  padding: 10px;
  border-radius: 5px;
  overflow-x: auto;
  margin: 10px 0;
}

.resource :deep(pre code) {
  background-color: transparent;
  padding: 0;
  color: #E6E6E6;
}

.resource :deep(blockquote) {
  border-left: 4px solid #007BFF;
  padding-left: 15px;
  margin: 15px 0;
  font-style: italic;
  background-color: rgba(0, 123, 255, 0.1);
  padding: 10px 15px;
  border-radius: 0 5px 5px 0;
}

.resource :deep(h1),
.resource :deep(h2),
.resource :deep(h3),
.resource :deep(h4),
.resource :deep(h5),
.resource :deep(h6) {
  color: #AEB6D5;
  margin-top: 1em;
  margin-bottom: 0.5em;
}

.resource :deep(h1) { font-size: 1.8rem; }
.resource :deep(h2) { font-size: 1.6rem; }
.resource :deep(h3) { font-size: 1.4rem; }
.resource :deep(h4) { font-size: 1.2rem; }
.resource :deep(h5) { font-size: 1.1rem; }
.resource :deep(h6) { font-size: 1rem; }

.resource :deep(table) {
  width: 100%;
  border-collapse: collapse;
  margin: 15px 0;
}

.resource :deep(th),
.resource :deep(td) {
  border: 1px solid #007BFF;
  padding: 8px 12px;
  text-align: left;
}

.resource :deep(th) {
  background-color: rgba(0, 123, 255, 0.2);
  font-weight: bold;
  color: #AEB6D5;
}

.resource :deep(tr:nth-child(even)) {
  background-color: rgba(255, 255, 255, 0.05);
}

@media (max-width: 768px) {
  h2.section-title {
    font-size: 2rem;
  }
  
  .resource h3 {
    font-size: 1.3rem;
  }
  
  .resources-cont {
    padding: 0 0.5rem;
  }
  
  .resource {
    padding: 8px;
  }
  
  .resource h3 {
    margin: 0 -8px;
    padding: 0 8px;
  }
}
</style>