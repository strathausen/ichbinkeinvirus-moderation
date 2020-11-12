import {Entity, PrimaryGeneratedColumn, Column} from "typeorm";

@Entity({
  name: 'wp_users'
})
export class User {

  @PrimaryGeneratedColumn()
  ID: number;

  @Column()
  user_login: string;

  @Column()
  user_pass: string;

  @Column()
  user_nicename: string

  @Column()
  user_email: string

  @Column()
  user_url: string

  @Column()
  user_registered: string

  @Column()
  user_status: string;

  @Column()
  display_name: string

}
