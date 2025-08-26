# Build stage
FROM node:23-alpine AS builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm ci

# Copy source code
COPY . .

# Build the application
RUN npm run generate

# Production stage
FROM nginx:alpine

# Copy nginx configuration
COPY .docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copy the env.js template
COPY .docker/env.js.template /usr/share/nginx/html/env.js.template

# Copy entrypoint script and ensure proper line endings
COPY .docker/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh && \
    sed -i 's/\r$//' /docker-entrypoint.sh && \
    cat /docker-entrypoint.sh

# Copy built files from the builder stage
# The output is in the .output directory for Nuxt 3
COPY --from=builder /app/.output/public /usr/share/nginx/html

# Expose web port
EXPOSE 80

# Use custom entrypoint script
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["nginx", "-g", "daemon off;"]