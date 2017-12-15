```
git log --author="$(git config --get user.name)" --after="2017-01-01" --before="2017-07-01" --pretty=tformat: --numstat | gawk '{add += $1; subs += $2 ; loc += $1 - $2} END {printf "add lines: %s removed lines : %s total lines: %s\n", add, subs, loc}' -
```
