#ifndef GGLOG_C_DATE_STUFF
#define GGLOG_C_DATE_STUFF

// An attempt at making things faster: date() is slow
// Pass things around as an integer: # days since 1 Jan 1970.
// 1 Jan 1970 = 0; 2 Jan 1970 = 1; etc.

char checkdate(int year, int month, int date);

// Every day is core day!
char is_core_day();
char * today_exercises();
//function intrp(type, dayNum)
// or function intrp(dayNum, array of types)

int intrp_w(int dayNum);
char* intrp_D(int dayNum);
char intrp_L(int dayNum);
int intrp_Y(int dayNum);
int intrp_z(int dayNum);
int intrp_m(int dayNum);

char intrp_capM(int dayNum);
char intrp_capM(int dayNum, char thisIsMonth);
int intrp_j(int dayNum);
int monthOffset(int month);
int ggcreatedate(int year, int month, int date);
char* ggcreateSQLdate(int dayNum);
int ggreadSQLdate(char* input);

#endif
