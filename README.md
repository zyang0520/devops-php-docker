# devops-php-docker

最小可运行的 PHP 全栈示例项目，用于学习 CI/CD。不含任何框架（Laravel/Symfony 等），仅使用 PHP 原生代码 + Composer + PHPUnit，前端使用原生 JS + Vite。

## 技术栈

- PHP 8.4（原生，无框架）+ Composer
- PHPUnit 11
- 原生前端（HTML/JS）+ Vite
- Docker + docker compose

## 功能

- 后端接口 `GET /api/health` 返回 `{"status":"ok"}`
- 前端页面请求该接口并展示健康状态

## 目录结构

```
.
├── backend/                  # PHP 后端
│   ├── public/
│   │   └── index.php         # 入口文件，路由 /api/health
│   ├── src/
│   │   └── HealthChecker.php
│   ├── tests/
│   │   └── HealthCheckerTest.php
│   ├── composer.json
│   ├── phpunit.xml
│   └── Dockerfile
├── frontend/                 # 前端
│   ├── src/
│   │   └── main.js
│   ├── index.html
│   ├── package.json
│   ├── vite.config.js
│   └── Dockerfile
├── docker/
│   └── frontend/
│       └── nginx.conf        # 前端容器内 nginx 配置，反向代理 /api 到 backend
├── docker-compose.yml
├── .gitignore
└── README.md
```

## 本地开发（不使用 Docker）

### 后端

```bash
cd backend
composer install
composer test          # 运行 PHPUnit
php -S 0.0.0.0:8080 -t public   # 启动内置服务器
curl http://localhost:8080/api/health
```

### 前端

```bash
cd frontend
npm install
npm run dev             # 开发模式，代理 /api 到 http://localhost:8080
npm run build           # 生产构建，产物在 frontend/dist
```

开发模式下访问 http://localhost:5173，前端会通过 vite.config.js 中的 proxy 配置将 `/api` 请求转发到本地运行的后端（需要先启动 `php -S 0.0.0.0:8080 -t public`）。

## Docker 一键启动

```bash
docker compose up -d --build
```

- 前端：http://localhost:5173 （nginx 提供静态文件，并反向代理 `/api` 到 backend 容器）
- 后端：http://localhost:8090/api/health （直接访问后端容器）

验证：

```bash
curl http://localhost:8090/api/health   # 直接访问后端
curl http://localhost:5173/api/health   # 经前端 nginx 反向代理
```

两者都应返回：

```json
{"status":"ok"}
```

停止服务：

```bash
docker compose down
```

## 说明

- 后端容器使用 PHP 内置开发服务器（`php -S`），未使用 php-fpm + nginx 组合，保持最小化，适合学习用途。
- 前端容器为多阶段构建：先用 Node 构建静态资源，再由 nginx 提供服务并反向代理 API 请求。
- 本项目暂不包含 CI/CD 配置，后续可在此基础上添加。
