import { FetchHttpClient } from "../../network/httpClient";
import type { HttpClient } from "../../network/httpClient/interface";


const baseUrl = 'http://localhost:8000/api';

export const httpClient: HttpClient = new FetchHttpClient(baseUrl);
