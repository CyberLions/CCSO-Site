# Build stage
FROM node:22-alpine as builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy source code
COPY . .

# Set environment variables
ENV NODE_ENV=production

# Build the Strapi application for production
RUN npm run build

# Expose API port
EXPOSE 3000

# Define a script to run the commands
# This ensures that 'npm run start' executes only if 'npm run crack' is successful
CMD ["sh", "-c", "npm run crack && npm run start"]