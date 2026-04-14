# Contributing to Mate/dto

Thank you for your interest in contributing to Mate/dto! To maintain a high-quality codebase and a clear history of changes, we follow specific standards.

## Git Conventional Commits

We use [Conventional Commits](https://www.conventionalcommits.org/) for all commit messages. This allows us to automatically generate changelogs and manage versioning effectively.

### Commit Message Format

Each commit message consists of a **header**, a **body**, and a **footer**. The header has a special format that includes a **type**, a **scope**, and a **subject**:

```text
<type>(<scope>): <subject>
<blank line>
<body>
<blank line>
<footer>
```

### Types

The `<type>` must be one of the following:

- **feat**: A new feature for the user, not a new feature for a build script.
- **fix**: A bug fix for the user, not a fix to a build script.
- **docs**: Changes to the documentation.
- **style**: Formatting, missing semi colons, etc; no production code change.
- **refactor**: Refactoring production code, e.g. renaming a variable.
- **perf**: Improvements in performance.
- **test**: Adding missing tests, refactoring tests; no production code change.
- **build**: Changes that affect the build system or external dependencies (example scopes: composer).
- **ci**: Changes to our CI configuration files and scripts.
- **chore**: Other changes that don't modify src or test files.
- **revert**: Reverts a previous commit.

### Examples

- `feat(core): add asymmetric visibility support for DTOs`
- `fix(mapper): resolve issue with null values in strict mode`
- `docs(readme): add installation instructions for Swoole environments`
- `perf(collection): optimize array iteration in MapCollection`

### Rules

1. Use the imperative, present tense: "change" not "changed" nor "changes".
2. Don't capitalize the first letter.
3. No dot (.) at the end.

## Development Workflow

1. Fork the repository.
2. Create your feature branch: `git checkout -b feat/my-new-feature`.
3. Commit your changes following the Conventional Commits standard.
4. Push to the branch: `git push origin feat/my-new-feature`.
5. Submit a Pull Request.

## Testing

Ensure all tests pass before submitting a PR:

```bash
composer test
```
