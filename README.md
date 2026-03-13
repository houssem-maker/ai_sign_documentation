# AiSign API v1

**Base URL** `https://dev1.aisign.ai/api/v1`

---

## Auth

```http
Authorization: Bearer sk_your_key
```

---

## Endpoints

| Method | Endpoint | Token |
|--------|----------|-------|
| `GET` | `/templates` | — |
| `GET` | `/templates/{id}` | — |
| `POST` | `/templates/{id}/use` | ✅ |
| `POST` | `/documents/upload` | — |
| `POST` | `/documents/{id}/recipients` | — |
| `POST` | `/documents/{id}/fields` | — |
| `POST` | `/documents/{id}/use` | ✅ |
| `GET` | `/documents` | — |
| `GET` | `/documents/{id}/status` | — |
| `GET` | `/documents/drafts/info` | — |
| `DELETE` | `/documents/cleanup` | — |
| `GET` | `/documents/{uuid}/download` | — |
| `GET` | `/tokens/balance` | — |
| `GET` | `/logs` | — |
| `GET/POST/PUT/DELETE` | `/webhooks` | — |

> ✅ = consumes 1 API token

---

## Document Workflow

```
POST /documents/upload
  → POST /documents/{id}/recipients
  → POST /documents/{id}/fields
  → POST /documents/{id}/use   ← token consumed here
  → GET  /documents/{uuid}/download
```

---

## Field Types

`SIGNATURE` `TEXT` `DATE` `NUMBER` `EMAIL` `COMPANY` `NOTES` `CHECKBOX`

**Positioning — pick one:**
- **Absolute** → `x`, `y` (0–100 scale) + `page`
- **OCR** → `reference_text` + `relative_position` (`above` `below` `left` `right`)

---

## Webhook Events

`document.uploaded` · `recipient.added` · `field.added`
`document.activated` · `document.viewed` · `field.signed` · `document.completed`

Verify with `X-Webhook-Signature` (HMAC-SHA256). URLs must be **HTTPS**.

---

## Key Limits

| Resource | Limit |
|----------|-------|
| Recipients / doc | 50 |
| File size | 10 MB |
| Draft docs | 10 |
| Log retention | 30 days |
| Webhooks / key | 30 |

---

## Response Shape

```json
{ "success": true, "message": "...", "data": {}, "errors": {} }
```

**Errors:** `401` invalid key · `402` no tokens · `422` validation · `404` not found