// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  css: ['~/assets/main.css'],
  modules: [
    '@nuxtjs/tailwindcss',
    '@nuxt/image'
  ],
  app: {
    head: {
      title: 'CCSO - Competitive Cyber Security Organization',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        { name: 'description', content: 'The purpose of the Penn State Competitive Cyber Security Organization is to provide members with an academic outlet to pursue and refine their cyber defense and security skills, collaborate with members of other technology-related clubs, expand their technical acumen, and provide the opportunity to apply such acumen in competitive environments through participation in various cyber security competitions.' }
      ],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/favicon.png' }
      ],
      script: [
        { src: '/env.js', defer: false }
      ]
    }
  },
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost:3000'
    }
  },
  devServer: {
    port: 8080
  },
  image: {
    // Set a default quality
    quality: 80,
    // Define presets for different image sizes
    presets: {
      avatar: {
        modifiers: {
          width: 50,
          height: 50,
          fit: 'cover',
        },
      },
      cover: {
        modifiers: {
          width: 1280,
          height: 720,
          fit: 'cover',
        },
      },
    },
    // Configure the built-in image optimizer
    ipx: {
      // You can set max width and height for generated images
      maxAge: 31536000, // Cache for 1 year
    },
    // Define supported screen sizes for responsive images
    screens: {
      'xs': 320,
      'sm': 640,
      'md': 768,
      'lg': 1024,
      'xl': 1280,
      'xxl': 1536,
      '2xl': 1536
    },
  }
})
