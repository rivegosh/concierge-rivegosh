module.exports = {
  apps: [
    {
      name: 'luxury-concierge',
      script: '../server/server.js',
      cwd: '../server',
      instances: 'max',
      exec_mode: 'cluster',
      env: {
        NODE_ENV: 'development',
        PORT: 3000
      },
      env_production: {
        NODE_ENV: 'production',
        PORT: 3000
      },
      error_file: '/var/log/luxury-concierge/error.log',
      out_file: '/var/log/luxury-concierge/out.log',
      log_file: '/var/log/luxury-concierge/combined.log',
      time: true,
      autorestart: true,
      watch: false,
      max_memory_restart: '1G',
      restart_delay: 3000
    }
  ]
};
