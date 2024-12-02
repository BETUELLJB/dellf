const express = require('express');
const { GoogleGenerativeAI } = require('@google/generative-ai');
const dotenv = require('dotenv');

dotenv.config();
const app = express();
const PORT = process.env.PORT || 3000;

// Configurar o middleware para JSON
app.use(express.json());

// Inicializar o cliente Gemini
const genAI = new GoogleGenerativeAI(process.env.GEMINI_API_KEY);
const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });

// Endpoint para gerar texto
app.post('/generate-text', async (req, res) => {
    const { prompt } = req.body;

    // Verificar se o prompt foi fornecido
    if (!prompt) {
        return res.status(400).json({ error: 'Prompt é obrigatório.' });
    }

    try {
        const result = await model.generateContent(prompt);
        res.json({ text: result.response.text() });
    } catch (error) {
        // Caso o erro seja relacionado à API Gemini
        if (error.response) {
            console.error('Erro na API Gemini:', error.response.data);
            res.status(500).json({ error: 'Erro ao gerar conteúdo com a API Gemini.' });
        } else if (error.code === 'ENOTFOUND') {
            // Se o erro for de rede (ex: sem conexão com a internet)
            console.error('Erro de rede:', error.message);
            res.status(503).json({ error: 'Erro de conexão. Verifique sua internet e tente novamente.' });
        } else {
            // Outros tipos de erro inesperado
            console.error('Erro desconhecido:', error.message);
            res.status(500).json({ error: 'Erro inesperado. Tente novamente mais tarde.' });
        }
    }
});

app.listen(PORT, () => {
    console.log(`Servidor Node.js a correr na porta ${PORT}`);
});
