export default {
  enabled: true,
  origin: ['http://localhost:8080', 'https://staging.psuccso.org', 'https://psuccso.org'],
  methods: ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
  allowedHeaders: ['Content-Type', 'Authorization', 'Origin', 'Accept'],
  exposedHeaders: ['Content-Type', 'Authorization'],
  credentials: true,
  maxAge: 86400,
}; 