# Critério Gourmet 🍽️

Um sistema moderno de avaliação de restaurantes desenvolvido com Laravel e Tailwind CSS.

![Critério Gourmet](public/images/preview.png)

## ✨ Características

- 🎨 Interface moderna e responsiva com tema escuro
- ⭐ Sistema de avaliação com notas para comida, serviço e ambiente
- 📸 Upload e gerenciamento de fotos
- 📍 Integração com ViaCEP para busca automática de endereços
- 🔍 Busca avançada e filtros por categoria, cozinha e avaliação
- 📱 Design totalmente responsivo
- 🌙 Tema escuro elegante
- ⚡ Animações suaves e interativas
- 🔒 Sistema de autenticação completo
- 📊 Dashboard com estatísticas

## 🚀 Tecnologias Utilizadas

- PHP 8.1+
- Laravel 10.x
- MySQL 8.0+
- Tailwind CSS
- Alpine.js
- Font Awesome
- Google Maps API

## 📋 Pré-requisitos

- PHP 8.1 ou superior
- Composer
- Node.js e NPM
- MySQL 8.0 ou superior
- Servidor web (Apache/Nginx)

## 🔧 Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/criterio-gourmet.git
cd criterio-gourmet
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Instale as dependências do Node:
```bash
npm install
```

4. Copie o arquivo de ambiente:
```bash
cp .env.example .env
```

5. Configure o arquivo .env com suas credenciais de banco de dados

6. Gere a chave da aplicação:
```bash
php artisan key:generate
```

7. Execute as migrações:
```bash
php artisan migrate
```

8. Compile os assets:
```bash
npm run build
```

9. Inicie o servidor:
```bash
php artisan serve
```

## 🌟 Funcionalidades

### Usuários
- Registro e login
- Perfil personalizado
- Histórico de avaliações
- Fotos de perfil

### Restaurantes
- Cadastro completo com fotos
- Categorização por tipo de cozinha
- Horário de funcionamento
- Localização com mapa
- Preço médio

### Avaliações
- Notas separadas para comida, serviço e ambiente
- Comentários detalhados
- Upload de fotos
- Votos úteis
- Respostas do restaurante

### Busca e Filtros
- Busca por nome, categoria ou cozinha
- Filtros por avaliação
- Ordenação por diferentes critérios
- Mapa interativo

## 📱 Responsividade

O sistema é totalmente responsivo e funciona perfeitamente em:
- Desktops
- Tablets
- Smartphones

## 🎨 Personalização

Você pode personalizar facilmente:
- Cores do tema
- Logo
- Textos
- Configurações de e-mail
- Integrações

## 🔒 Segurança

- Proteção CSRF
- Validação de dados
- Sanitização de inputs
- Autenticação segura
- Proteção contra XSS

## 📈 Performance

- Lazy loading de imagens
- Cache de consultas
- Otimização de assets
- Compressão de imagens
- Minificação de CSS/JS

## 🤝 Contribuindo

1. Faça um Fork do projeto
2. Crie uma Branch para sua Feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📧 Contato

Seu Nome - [@seu_twitter](https://twitter.com/seu_twitter) - email@exemplo.com

Link do Projeto: [https://github.com/seu-usuario/criterio-gourmet](https://github.com/seu-usuario/criterio-gourmet)

## 🙏 Agradecimentos

- [Laravel](https://laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Alpine.js](https://alpinejs.dev)
- [Font Awesome](https://fontawesome.com)
- [ViaCEP](https://viacep.com.br)
