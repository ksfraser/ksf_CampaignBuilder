# CampaignBuilder - Business Requirements

**Document ID:** BR-CAMPAIGN-001  
**Module:** ksf_CampaignBuilder  
**Version:** 1.0.0  
**Author:** KSFII  
**Date:** 2025-01-01  

---

## 1. Overview

The CampaignBuilder module provides a framework-agnostic marketing automation campaign engine with visual workflow capabilities. It enables users to create, manage, and execute multi-step marketing campaigns with configurable triggers, nodes, and outcomes.

## 2. Purpose

CampaignBuilder empowers marketing teams to design sophisticated campaign workflows without requiring technical expertise. The module implements a node-based workflow system where each node represents a marketing action (email, notification, task) connected through outcomes (transitions).

## 3. Scope

### 3.1 Core Features

- **Campaign Management**
  - Create, edit, clone, and delete campaigns
  - Campaign status workflow: draft → active → paused → completed
  - Scheduled campaign activation with start/end dates
  - Campaign validation and cycle detection

- **Workflow Builder**
  - Node-based campaign design interface
  - Multiple node types: trigger, action, condition, delay
  - CampaignNode entity representing individual workflow steps
  - CampaignOutcome for node-to-node connections
  - CampaignTrigger for campaign entry points

- **Campaign Execution**
  - Campaign activation and deactivation
  - Entry point identification for execution paths
  - Campaign outcome tracking and analytics

### 3.2 Out of Scope

- Email sending/spooling (delegated to EmailManager)
- Contact list management
- Analytics/reporting dashboards
- Multi-language support
- Campaign templates

## 4. Integration Dependencies

| Module | Dependency Type | Purpose |
|--------|-----------------|---------|
| ksf_CRM | Required | Contact/debtor management for campaign targets |
| ksf_EmailManager | Optional | Email action nodes |
| ksf_ModulesDAO | Required | Data persistence layer |

## 5. User Roles

| Role | Permissions |
|------|-------------|
| Marketing Manager | Full campaign CRUD, activation |
| Marketing Analyst | Read-only, reports |
| Developer | Debug, technical configuration |

## 6. Assumptions

- Campaign data stored via repository pattern
- JSON serialization for API responses
- PHP 7.3+ compatibility required
- MySQL/MariaDB as primary database

## 7. Acceptance Criteria

- [ ] Campaign entity serializes correctly to JSON
- [ ] Cycle detection prevents infinite loops
- [ ] Workflow validation returns all errors
- [ ] Node CRUD operations function correctly
- [ ] Trigger associations work as expected