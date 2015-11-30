//Place at ../ and compile, then it will count total #lines
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
void dispfsize(int bytes) {
  char *output; output = malloc(sizeof(char)*10); int tplace = 0;
  if(bytes < 1024) { printf("%d bytes", bytes); }
  else { float val = bytes; val /= 1024; printf("%.3f kb", val); }
}
int main() {
  const size_t listEntries = 27; const size_t entrySize = 30; char flist[listEntries][entrySize];
  strcpy(flist[0], "about.php");
  strcpy(flist[1], "accept.php");
  strcpy(flist[2], "src/adduser.php");
  strcpy(flist[3], "astext.php");
  strcpy(flist[4], "config.php");
  strcpy(flist[5], "src/datetime.php");
  strcpy(flist[6], "css/workouts.css");
  strcpy(flist[7], "js/workouts.js");
  strcpy(flist[8], "demo.php");
  strcpy(flist[9], "nginx_gglog.conf");
  strcpy(flist[10], "js/ggLogEssentials.js");
  strcpy(flist[11], "css/ggLogEssentials.css");
  strcpy(flist[12], "css/index.css");
  strcpy(flist[13], "index.php");
  strcpy(flist[14], "install.php");
  strcpy(flist[15], "js/manageseasons.js");
  strcpy(flist[16], "manageseasons.php");
  strcpy(flist[17], "navbar.php");
  strcpy(flist[18], "README.md");
  strcpy(flist[19], "src/seasons.php");
  strcpy(flist[20], "src/weeks.php");
  strcpy(flist[21], "src/workouts.php");
  strcpy(flist[22], "login.php");
  strcpy(flist[23], "src/loginbackend.php");
  strcpy(flist[24], "register.php");
  strcpy(flist[25], "src/registercheck.php");
  strcpy(flist[26], "img/avatar.php");
  int count_newlines = 0; int i; int currentcounter = 0; char c; int tfsize = 0;
  printf("\t\t    This file   |cumulative fsize\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
  for(i=0;i<listEntries;++i) {
    printf("FILE %s", flist[i]); FILE *in_file = fopen(flist[i], "r"); currentcounter = count_newlines; int bcount = 0;
    while( (c=fgetc(in_file)) != EOF ) { ++bcount; if(c == '\n') { ++count_newlines; } }
    tfsize += bcount;
    if(strlen(flist[i]) < 27) printf("\t");
    if(strlen(flist[i]) < 19) printf("\t");
    if(strlen(flist[i]) < 11) printf("\t");
    if(strlen(flist[i]) < 3) printf("\t");
    printf("%d\t| %d\t| ", count_newlines-currentcounter, count_newlines); dispfsize(bcount); printf("\n"); fclose(in_file);
  }
  printf("\n%d lines were found with ", count_newlines); dispfsize(tfsize); printf("\n\n");
  return 0; }
