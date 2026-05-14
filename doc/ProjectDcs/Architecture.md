# CampaignBuilder - Architecture

**Document ID:** ARCH-CAMPAIGN-001  
**Module:** ksf_CampaignBuilder  
**Version:** 1.0.0  

---

## 1. Module Overview

CampaignBuilder implements a node-based workflow engine for marketing campaign automation. The architecture follows domain-driven design principles with clear separation between entities, services, and repositories.

## 2. Class Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                     Campaign                                 │
├─────────────────────────────────────────────────────────────┤
│ - id: string                                                 │
│ - name: string                                               │
│ - description: string                                       │
│ - status: string                                             │
│ - createdAt: DateTime                                        │
│ - updatedAt: ?DateTime                                       │
│ - startsAt: ?DateTime                                        │
│ - endsAt: ?DateTime                                          │
│ - nodes: CampaignNode[]                                      │
│ - triggers: CampaignTrigger[]                              │
│ - isActive: bool                                            │
├─────────────────────────────────────────────────────────────┤
│ + activate(): self                                           │
│ + deactivate(): self                                         │
│ + addNode(node: CampaignNode): self                         │
│ + addTrigger(trigger: CampaignTrigger): self                 │
│ + validate(): string[]                                        │
│ + hasCycle(): bool                                          │
│ + isScheduled(): bool                                       │
└─────────────────────────────────────────────────────────────┘
                              │
                              │ 1..*
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                    CampaignNode                             │
├─────────────────────────────────────────────────────────────┤
│ - id: string                                                 │
│ - type: string                                               │
│ - config: array                                              │
│ - outcomes: CampaignOutcome[]                               │
├─────────────────────────────────────────────────────────────┤
│ + addOutcome(outcome: CampaignOutcome): self                │
│ + validate(): string[]                                       │
└─────────────────────────────────────────────────────────────┘
                              │
                              │ 0..*
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                   CampaignOutcome                            │
├─────────────────────────────────────────────────────────────┤
│ - id: string                                                 │
│ - targetNodeId: string                                       │
│ - condition: string                                          │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                  CampaignTrigger                             │
├─────────────────────────────────────────────────────────────┤
│ - id: string                                                 │
│ - type: string                                               │
│ - config: array                                              │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                  CampaignService                            │
├─────────────────────────────────────────────────────────────┤
│ - repository: CampaignRepositoryInterface                    │
├─────────────────────────────────────────────────────────────┤
│ + create(data): Campaign                                     │
│ + update(id, data): Campaign                                 │
│ + activate(id): Campaign                                    │
│ + validate(id): string[]                                     │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│           CampaignRepositoryInterface                        │
├─────────────────────────────────────────────────────────────┤
│ + findById(id): ?Campaign                                   │
│ + findAll(filters): Campaign[]                              │
│ + save(campaign): Campaign                                   │
│ + delete(id): bool                                          │
└─────────────────────────────────────────────────────────────┘
```

## 3. Directory Structure

```
ksf_CampaignBuilder/
├── src/Ksfraser/CampaignBuilder/
│   ├── Entity/
│   │   ├── Campaign.php
│   │   ├── CampaignNode.php
│   │   ├── CampaignOutcome.php
│   │   └── CampaignTrigger.php
│   ├── Service/
│   │   └── CampaignService.php
│   └── Repository/
│       └── CampaignRepositoryInterface.php
├── tests/
│   └── Unit/
│       └── CampaignEntityTest.php
└── doc/ProjectDcs/
```

## 4. Key Design Patterns

### 4.1 Entity Pattern
Campaign and related entities use immutable-style construction with fluent setters.

### 4.2 Repository Pattern
Data access abstracted via `CampaignRepositoryInterface` enabling unit testing without database.

### 4.3 Cycle Detection
Depth-first search algorithm prevents infinite loops in workflow graphs.

## 5. Technology Stack

| Component | Technology |
|-----------|------------|
| Language | PHP 7.3+ |
| Serialization | JsonSerializable |
| Testing | PHPUnit |
| Patterns | Repository, Entity |

## 6. Database Schema (Expected)

```sql
CREATE TABLE fa_campaign (
    id VARCHAR(36) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    status VARCHAR(50) DEFAULT 'draft',
    is_active TINYINT(1) DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME,
    starts_at DATETIME,
    ends_at DATETIME
);

CREATE TABLE fa_campaign_node (
    id VARCHAR(36) PRIMARY KEY,
    campaign_id VARCHAR(36),
    type VARCHAR(50),
    config JSON,
    FOREIGN KEY (campaign_id) REFERENCES fa_campaign(id)
);

CREATE TABLE fa_campaign_outcome (
    id VARCHAR(36) PRIMARY KEY,
    node_id VARCHAR(36),
    target_node_id VARCHAR(36),
    condition VARCHAR(255)
);

CREATE TABLE fa_campaign_trigger (
    id VARCHAR(36) PRIMARY KEY,
    campaign_id VARCHAR(36),
    type VARCHAR(50),
    config JSON
);
```