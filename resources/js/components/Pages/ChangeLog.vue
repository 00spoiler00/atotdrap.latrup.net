<template>
    <v-card>
      <v-card-title>
        Canvis de l'aplicació
      </v-card-title>
  
      <v-card-text>
        <div class="markdown-content" v-html="changelog"></div>
      </v-card-text>
  
    </v-card>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { marked } from 'marked'
  
  // Reactive variable for changelog content
  const changelog = ref('')
  
  // Fetch and parse the CHANGELOG.md on component mount
  onMounted(() => {
    fetch('./CHANGELOG.md')
      .then(response => response.text())
      .then(data => {
        changelog.value = marked.parse(data)
      })
      .catch(error => console.error('Error fetching data:', error))
  })
  
  </script>
  