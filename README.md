# CCSO Website

A modern, full-stack website for the **Penn State Competitive Cyber Security Organization (CCSO)**, featuring event management, member resources, and CTF competition information.

## 🚀 Overview

The CCSO Website is a comprehensive platform that showcases the organization's activities, events, and resources. Built with modern web technologies, it provides an engaging experience for members, sponsors, and visitors interested in cybersecurity competitions and education.

## ✨ Features

- **Event Management**: Dynamic event pages with countdown timers (e.g., SillyCTF)
- **Activity Showcase**: Interactive flip cards displaying organization activities
- **Calendar Integration**: Upcoming events calendar widget
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Content Management**: Headless CMS integration with Strapi
- **Discord Integration**: Direct links to community Discord server
- **Modern UI/UX**: Animated backgrounds, smooth transitions, and engaging visuals

## 🛠️ Tech Stack

### Frontend
- **Framework**: [Nuxt 3](https://nuxt.com/) (Vue.js)
- **Styling**: [Tailwind CSS](https://tailwindcss.com/)
- **Icons**: [Heroicons](https://heroicons.com/)
- **Image Optimization**: [@nuxt/image](https://image.nuxtjs.org/)
- **Charts**: [Chart.js](https://www.chartjs.org/)
- **Maps**: [Leaflet](https://leafletjs.com/)
- **TypeScript**: Full type safety support

### Backend
- **CMS**: [Strapi 5.20.0](https://strapi.io/)
- **Database**: PostgreSQL
- **Plugins**: 
  - CKEditor for rich text editing
  - SEO plugin
  - Documentation plugin
  - Users & Permissions

## 📁 Project Structure

```
.
├── frontend/          # Nuxt 3 frontend application
│   ├── assets/        # Static assets (CSS, images)
│   ├── components/    # Vue components
│   ├── composables/   # Vue composables
│   ├── pages/         # Application pages/routes
│   ├── utils/         # Utility functions
│   └── public/        # Public static files
│
└── backend/           # Strapi CMS backend
    ├── config/        # Strapi configuration
    ├── database/      # Database migrations
    ├── src/           # Strapi source code
    └── public/        # Public files
```

## 🚦 Getting Started

### Prerequisites

- **Node.js**: >=18.0.0 <=22.x.x
- **npm**: >=6.0.0
- **PostgreSQL**: For backend database

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```

2. **Install Frontend Dependencies**
   ```bash
   cd frontend
   npm install
   ```

3. **Install Backend Dependencies**
   ```bash
   cd ../backend
   npm install
   ```

4. **Configure Environment Variables**

   Create a `.env` file in the `frontend` directory:
   ```env
   NUXT_PUBLIC_API_BASE=http://localhost:1337
   ```

   Create a `.env` file in the `backend` directory with your Strapi configuration:
   ```env
   DATABASE_CLIENT=postgres
   DATABASE_HOST=localhost
   DATABASE_PORT=5432
   DATABASE_NAME=ccso_db
   DATABASE_USERNAME=your_username
   DATABASE_PASSWORD=your_password
   ```

### Development

1. **Start the Backend (Strapi)**
   ```bash
   cd backend
   npm run develop
   ```
   The Strapi admin panel will be available at `http://localhost:1337/admin`

2. **Start the Frontend (Nuxt)**
   ```bash
   cd frontend
   npm run dev
   ```
   The website will be available at `http://localhost:8080`

### Building for Production

**Frontend:**
```bash
cd frontend
npm run build
npm run preview
```

**Backend:**
```bash
cd backend
npm run build
npm run start
```

## 📄 Available Scripts

### Frontend
- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run generate` - Generate static site
- `npm run preview` - Preview production build
- `npm run lint` - Run ESLint
- `npm run format` - Format code with Prettier

### Backend
- `npm run develop` - Start Strapi in development mode
- `npm run start` - Start Strapi in production mode
- `npm run build` - Build Strapi admin panel
- `npm run strapi` - Run Strapi CLI commands

## 🎯 Key Pages

- **Home** (`/`) - Organization overview and activities
- **About** (`/about`) - Information about CCSO
- **Events** (`/events/*`) - Event pages including SillyCTF
- **Sponsor Us** (`/sponsor-us`) - Sponsorship information

## 🎨 Design Features

- **Animated Background**: Lava lamp-style gradient animation
- **Responsive Layout**: Mobile-first design with breakpoints
- **Smooth Transitions**: Page transitions and component animations
- **Modern UI Components**: Flip cards, calendar widgets, rotating galleries

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is private and proprietary to the Penn State Competitive Cyber Security Organization.

## 🔗 Links

- **Discord**: [Join our Discord server](https://discord.gg/NhN5RpBXkm)
- **Organization**: Penn State Competitive Cyber Security Organization

## 👥 Maintainers

Penn State Competitive Cyber Security Organization (CCSO)

---

**Note**: This website is maintained by the CCSO development team. For questions or issues, please contact the organization through Discord or other official channels.

