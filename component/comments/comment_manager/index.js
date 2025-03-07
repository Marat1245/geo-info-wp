// console.log("Loading index.js...");

import { CommentManager } from './handlers.js';
import { CommentLikes } from './likes.js';

document.addEventListener('DOMContentLoaded', () => {
    new CommentManager();
    new CommentLikes();
}); 